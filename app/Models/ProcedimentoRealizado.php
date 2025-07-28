<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcedimentoRealizado extends Model
{
    use HasFactory;
    protected $table = 'procedimentos_realizados';
    protected $primaryKey = 'id_procedimento_realizado';
    public $timestamps = false;
    protected $fillable = [
        'quantidade',
        'valor_cobrado',
        'descricao',
        'anexo',
        'id_consulta',
        'id_procedimento',
        'id_orcamento_item',
    ];

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'id_consulta');
    }

    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(Procedimento::class, 'id_procedimento', 'id_procedimento');
    }

    public function orcamentoItem(): BelongsTo
    {
        return $this->belongsTo(OrcamentoItem::class, 'id_orcamento_item', 'id_orcamento_item');
    }
}