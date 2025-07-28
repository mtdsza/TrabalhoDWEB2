<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoFinanceira extends Model
{
    use HasFactory;
    protected $table = 'movimentacoes_financeiras';
    protected $primaryKey = 'id_movimentacao_financeira';
    public $timestamps = false;
    protected $fillable = [
        'descricao',
        'valor',
        'tipo',
        'data_movimentacao',
        'id_consulta',
        'id_orcamento',
        'id_procedimento_realizado',
        'id_parcela_paga',
    ];

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'id_consulta');
    }

    public function orcamento(): BelongsTo
    {
        return $this->belongsTo(Orcamento::class, 'id_orcamento', 'id_orcamento');
    }

    public function procedimentoRealizado(): BelongsTo
    {
        return $this->belongsTo(ProcedimentoRealizado::class, 'id_procedimento_realizado', 'id_procedimento_realizado');
    }

    public function parcela(): BelongsTo
    {
        return $this->belongsTo(ParcelaAReceber::class, 'id_parcela_paga', 'id_parcela');
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