<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\Prontuario;
use Illuminate\Database\QueryException;
use App\Models\Profissional; 

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes.index', ['pacientes' => $pacientes]);
    }
    public function create()
    {
        $this->authorize('manage-patients');
        return view('pacientes.create');
    }
    public function store(Request $request)
    {
        $this->authorize('manage-patients');
        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'telefone' => preg_replace('/[^0-9]/', '', $request->telefone),
        ]);
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|digits:11|unique:pacientes',
            'nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:13',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
        ]);
        Paciente::create($request->all());

        return redirect()->route('pacientes.index')
                         ->with('success', 'Paciente cadastrado com sucesso!');
    }
    public function show(string $id)
    {
        $paciente = Paciente::with(['prontuarios' => function ($query) {
            $query->orderBy('data_registro', 'desc');
        }, 'prontuarios.consulta'])->findOrFail($id);
        $prontuarioGeral = $paciente->prontuarios->firstWhere('id_consulta', null);

        return view('pacientes.show', [
            'paciente' => $paciente,
            'prontuarioGeral' => $prontuarioGeral,
        ]);
    }
    public function edit(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', ['paciente' => $paciente]);
    }
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $request->merge([
            'cpf' => preg_replace('/[^0-g]/', '', $request->cpf),
            'telefone' => preg_replace('/[^0-9]/', '', $request->telefone),
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|digits:11|unique:pacientes,cpf,' . $paciente->id_paciente . ',id_paciente',
            'nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:13',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
                         ->with('success', 'Paciente atualizado com sucesso!');
    }
    public function destroy(string $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->delete();

            return redirect()->route('pacientes.index')
                             ->with('success', 'Paciente excluído com sucesso!');

        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('pacientes.index')
                                 ->with('error', 'Este paciente não pode ser excluído, pois possui um histórico de consultas no sistema.');
            }
            return redirect()->route('pacientes.index')
                             ->with('error', 'Ocorreu um erro inesperado ao tentar excluir o paciente.');
        }
    }

    public function salvarHistorico(Request $request, Paciente $paciente)
    {
        //apenas profissionais podem realizar essa ação
        $this->authorize('is-professional');
        $request->validate([
            'historico_odontologico' => 'nullable|string',
            'tratamentos_anteriores' => 'nullable|string',
        ]);
        //pega o id do profissional a partir do user logado
        $profissionalId = auth()->user()->id_profissional;
        //atualiza o prontuário
        Prontuario::updateOrCreate(
            [
                'id_paciente' => $paciente->id_paciente,
                'id_consulta' => null
            ],
            [
                'historico_odontologico' => $request->historico_odontologico,
                'tratamentos_anteriores' => $request->tratamentos_anteriores,
                'id_profissional' => $profissionalId,
            ]
        );
        return redirect()->route('pacientes.show', $paciente->id_paciente)
                        ->with('success', 'Histórico geral do paciente salvo com sucesso!');
    }
}