<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\Procedimento; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //

class OrcamentoController extends Controller
{
    public function index()
    {
        $orcamentos = Orcamento::with('paciente')->latest('data_emissao')->get();

        return view('orcamentos.index', ['orcamentos' => $orcamentos]);
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $profissionais = Profissional::where('ativo', true)->get();
        $procedimentos = Procedimento::all();

        return view('orcamentos.create', [
            'pacientes' => $pacientes,
            'profissionais' => $profissionais,
            'procedimentos' => $procedimentos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_profissional' => 'required|exists:profissionais,id_profissional',
            'procedimentos' => 'required|array|min:1',
            'procedimentos.*.id_procedimento' => 'required|exists:procedimentos,id_procedimento',
            'procedimentos.*.valor_unitario' => 'required|numeric|min:0',
        ]);
        try {
            DB::beginTransaction();
            $valorTotal = 0;
            foreach ($request->procedimentos as $proc) {
                $valorTotal += $proc['valor_unitario'];
            }
            $orcamento = Orcamento::create([
                'id_paciente' => $request->id_paciente,
                'id_profissional' => $request->id_profissional,
                'data_emissao' => now(),
                'valor_total' => $valorTotal,
            ]);
            foreach ($request->procedimentos as $proc) {
                $orcamento->itens()->create([
                    'id_procedimento' => $proc['id_procedimento'],
                    'valor_unitario' => $proc['valor_unitario'],
                    'quantidade' => 1,
                ]);
            }
            DB::commit();
            return redirect()->route('orcamentos.index')
                             ->with('success', 'Orçamento criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao criar o orçamento: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        $orcamento = Orcamento::with('paciente', 'profissional', 'itens.procedimento', 'parcelas')->findOrFail($id);

        return view('orcamentos.show', ['orcamento' => $orcamento]);
    }

    public function edit(string $id)
    {
        $orcamento = Orcamento::with('itens.procedimento')->findOrFail($id);
        $pacientes = Paciente::all();
        $profissionais = Profissional::where('ativo', true)->get();
        $procedimentos = Procedimento::all();
        return view('orcamentos.edit', [
            'orcamento' => $orcamento,
            'pacientes' => $pacientes,
            'profissionais' => $profissionais,
            'procedimentos' => $procedimentos,
        ]);
    }
    public function update(Request $request, string $id)
    {
        $orcamento = Orcamento::findOrFail($id);

        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_profissional' => 'required|exists:profissionais,id_profissional',
            'procedimentos' => 'sometimes|array',
            'procedimentos.*.id_procedimento' => 'required|exists:procedimentos,id_procedimento',
            'procedimentos.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            $orcamento->itens()->delete();
            $valorTotal = 0;
            $procedimentos = $request->procedimentos ?? [];
            foreach ($procedimentos as $proc) {
                $orcamento->itens()->create([
                    'id_procedimento' => $proc['id_procedimento'],
                    'valor_unitario' => $proc['valor_unitario'],
                    'quantidade' => 1,
                ]);
                $valorTotal += $proc['valor_unitario'];
            }
            $orcamento->update([
                'id_paciente' => $request->id_paciente,
                'id_profissional' => $request->id_profissional,
                'valor_total' => $valorTotal,
            ]);

            DB::commit();

            return redirect()->route('orcamentos.index')
                             ->with('success', 'Orçamento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar o orçamento: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->delete();
        return redirect()->route('orcamentos.index')
                         ->with('success', 'Orçamento excluído com sucesso!');
    }
        public function gerarParcelas(Request $request, Orcamento $orcamento)
    {
        $request->validate(['numero_parcelas' => 'required|integer|min:1']);

        $numeroParcelas = $request->numero_parcelas;
        $valorTotal = $orcamento->valor_total;
        $valorParcela = round($valorTotal / $numeroParcelas, 2);
        $valorPrimeirasParcelas = $valorParcela;
        $somaTotal = $valorParcela * $numeroParcelas;
        if ($somaTotal != $valorTotal) {
            $diferenca = $valorTotal - $somaTotal;
            $valorPrimeirasParcelas += $diferenca;
        }
        $orcamento->parcelas()->delete();
        for ($i = 1; $i <= $numeroParcelas; $i++) {
            $orcamento->parcelas()->create([
                'descricao' => "Parcela {$i}/{$numeroParcelas}",
                'valor' => ($i == 1) ? $valorPrimeirasParcelas : $valorParcela,
                'data_vencimento' => now()->addMonths($i),
            ]);
        }
        return redirect()->route('orcamentos.show', $orcamento->id_orcamento)
                         ->with('success', 'Parcelas geradas com sucesso!');
    }
}
