<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrcamentoItem extends Model
{
    use HasFactory;
    protected $table = 'orcamento_itens';
    protected $primaryKey = 'id_orcamento_item';
    public $timestamps = false;
    protected $fillable = [
        'valor_unitario',
        'quantidade',
        'id_orcamento',
        'id_procedimento',
    ];

    public function orcamento(): BelongsTo
    {
        return $this->belongsTo(Orcamento::class, 'id_orcamento', 'id_orcamento');
    }

    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(Procedimento::class, 'id_procedimento', 'id_procedimento');
    }
}