<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParcelaAReceber extends Model
{
    use HasFactory;
    protected $table = 'parcelas_a_receber';
    protected $primaryKey = 'id_parcela';
    public $timestamps = false;
    protected $fillable = [
        'descricao',
        'valor',
        'data_vencimento',
        'status',
        'data_pagamento',
        'id_orcamento',
    ];

    public function orcamento(): BelongsTo
    {
        return $this->belongsTo(Orcamento::class, 'id_orcamento', 'id_orcamento');
    }
}