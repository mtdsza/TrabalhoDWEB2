<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orcamento extends Model
{
    use HasFactory;
    protected $table = 'orcamentos';
    protected $primaryKey = 'id_orcamento';
    public $timestamps = false;
    protected $fillable = [
        'data_emissao',
        'data_validade',
        'valor_total',
        'id_paciente',
        'id_profissional',
        'id_consulta',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function profissional(): BelongsTo
    {
        return $this->belongsTo(Profissional::class, 'id_profissional', 'id_profissional');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(OrcamentoItem::class, 'id_orcamento', 'id_orcamento');
    }

    public function parcelas(): HasMany
    {
        return $this->hasMany(ParcelaAReceber::class, 'id_orcamento', 'id_orcamento');
    }
}