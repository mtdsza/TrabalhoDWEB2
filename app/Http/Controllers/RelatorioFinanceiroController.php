<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoFinanceira;
use Illuminate\Http\Request;

class RelatorioFinanceiroController extends Controller
{
    public function index(Request $request)
    {
        $dataInicio = $request->input('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = $request->input('data_fim', now()->endOfMonth()->toDateString());
        $movimentacoes = MovimentacaoFinanceira::whereBetween('data_movimentacao', [$dataInicio, $dataFim])
                                               ->orderBy('data_movimentacao', 'desc')
                                               ->get();

        $totalEntradas = $movimentacoes->where('tipo', 'Entrada')->sum('valor');
        $totalSaidas = $movimentacoes->where('tipo', 'Saida')->sum('valor');
        $saldo = $totalEntradas - $totalSaidas;

        return view('relatorios.financeiro', [
            'movimentacoes' => $movimentacoes,
            'totalEntradas' => $totalEntradas,
            'totalSaidas' => $totalSaidas,
            'saldo' => $saldo,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);
    }
    public function createDespesa()
    {
        return view('relatorios.create-despesa');
    }
    public function storeDespesa(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data_movimentacao' => 'required|date',
        ]);

        MovimentacaoFinanceira::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_movimentacao' => $request->data_movimentacao,
            'tipo' => 'Saida',
        ]);

        return redirect()->route('relatorios.financeiro')->with('success', 'Despesa lançada com sucesso!');
    }
}