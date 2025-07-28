<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\Prontuario;
use App\Models\Estoque;
use App\Models\UsoMateriaisConsulta;
use Illuminate\Support\Facades\DB;
use App\Rules\HorarioDisponivel;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('paciente', 'profissional')
                              ->orderBy('data_inicio', 'desc')
                              ->get();

        return view('consultas.index', ['consultas' => $consultas]);
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $profissionais = Profissional::where('ativo', true)->get();
        return view('consultas.create', [
            'pacientes' => $pacientes,
            'profissionais' => $profissionais,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_profissional' => 'required|exists:profissionais,id_profissional',
            'data_inicio' => ['required', 'date', new HorarioDisponivel($request->id_profissional, $request->data_inicio)],
            'descricao' => 'nullable|string',
        ]); 

        Consulta::create([
            'id_paciente' => $request->id_paciente,
            'id_profissional' => $request->id_profissional,
            'data_inicio' => $request->data_inicio,
            'descricao' => $request->descricao,
            'situacao' => 'Agendada',
        ]);
        return redirect()->route('consultas.index')
                         ->with('success', 'Consulta agendada com sucesso!');
    }
    public function show(string $id)
    {
        $consulta = Consulta::with('paciente', 'profissional', 'prontuario', 'usoMateriais.itemEstoque', 'procedimentosRealizados.procedimento')->findOrFail($id);
        
        $itensEstoque = \App\Models\Estoque::all();

        return view('consultas.show', [
            'consulta' => $consulta,
            'itensEstoque' => $itensEstoque,
        ]);
    }
    public function edit(string $id)
    {
        $consulta = Consulta::findOrFail($id);
        $pacientes = Paciente::all();
        $profissionais = Profissional::where('ativo', true)->get();

        return view('consultas.edit', [
            'consulta' => $consulta,
            'pacientes' => $pacientes,
            'profissionais' => $profissionais,
        ]);
    }
    public function update(Request $request, string $id)
    {
        $consulta = Consulta::findOrFail($id);
        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_profissional' => 'required|exists:profissionais,id_profissional',
            'data_inicio' => ['required', 'date', new HorarioDisponivel($request->id_profissional, $request->data_inicio, $consulta->id_consulta)],
            'descricao' => 'nullable|string',
        ]);
        $consulta->update($request->all());
        return redirect()->route('consultas.index')
                         ->with('success', 'Consulta atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->situacao = 'Cancelada';
        $consulta->save();

        return redirect()->route('consultas.index')
                         ->with('success', 'Consulta cancelada com sucesso!');
    }

    public function salvarProntuario(Request $request, Consulta $consulta)
    {
        $request->validate([
            'diagnostico' => 'nullable|string',
            'prescricoes' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        Prontuario::updateOrCreate(
            ['id_consulta' => $consulta->id_consulta],
            [
                'diagnostico' => $request->diagnostico,
                'prescricoes' => $request->prescricoes,
                'observacoes' => $request->observacoes,
                'id_paciente' => $consulta->id_paciente,
                'id_profissional' => $consulta->id_profissional,
            ]
        );

        return redirect()->route('consultas.show', $consulta->id_consulta)
                         ->with('success', 'Prontuário salvo com sucesso!');
    }
    public function adicionarMaterial(Request $request, Consulta $consulta)
    {
        $request->validate([
            'id_item_estoque' => 'required|exists:estoque,id_item_estoque',
            'quantidade' => 'required|numeric|min:0.001',
        ]);

        $itemEstoque = Estoque::findOrFail($request->id_item_estoque);

        if ($request->quantidade > $itemEstoque->quantidade) {
            return back()->with('error', 'Quantidade em estoque insuficiente!');
        }

        try {
            DB::beginTransaction();

            UsoMateriaisConsulta::create([
                'id_consulta' => $consulta->id_consulta,
                'id_item_estoque' => $request->id_item_estoque,
                'quantidade' => $request->quantidade,
            ]);

            $itemEstoque->decrement('quantidade', $request->quantidade);

            DB::commit();

            return redirect()->route('consultas.show', $consulta->id_consulta)
                             ->with('success', 'Material adicionado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao adicionar o material: ' . $e->getMessage());
        }
    }
    public function finalizar(Consulta $consulta)
    {
        $consulta->situacao = 'Realizada';
        $consulta->data_fim = now();
        $consulta->save();

        return redirect()->route('consultas.show', $consulta->id_consulta)
                         ->with('success', 'Atendimento finalizado e consulta marcada como Realizada.');
    }
}
