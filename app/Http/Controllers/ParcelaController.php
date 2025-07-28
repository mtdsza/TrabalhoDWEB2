<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParcelaAReceber;
use App\Models\MovimentacaoFinanceira;

class ParcelaController extends Controller
{
    public function pagar(ParcelaAReceber $parcela)
    {
        $parcela->status = 'Paga';
        $parcela->data_pagamento = now();
        $parcela->save();
        MovimentacaoFinanceira::create([
            'descricao' => "Recebimento da parcela {$parcela->descricao} do orçamento #{$parcela->id_orcamento}",
            'valor' => $parcela->valor,
            'tipo' => 'Entrada',
            'data_movimentacao' => now(),
            'id_orcamento' => $parcela->id_orcamento,
            'id_parcela_paga' => $parcela->id_parcela,
        ]);

        return redirect()->route('orcamentos.show', $parcela->id_orcamento)
                         ->with('success', 'Parcela marcada como paga com sucesso!');
    }
}
