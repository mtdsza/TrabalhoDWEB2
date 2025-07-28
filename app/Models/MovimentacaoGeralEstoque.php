<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoGeralEstoque extends Model
{
    use HasFactory;
    protected $table = 'movimentacoes_gerais_estoque';
    protected $primaryKey = 'id_movimentacao_geral';
    public $timestamps = false;
    protected $fillable = [
        'quantidade',
        'tipo',
        'justificativa',
        'data_movimentacao',
        'id_item_estoque',
    ];

    public function itemEstoque(): BelongsTo
    {
        return $this->belongsTo(Estoque::class, 'id_item_estoque', 'id_item_estoque');
    }
}