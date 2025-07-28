<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consulta extends Model
{
    use HasFactory;
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    public $timestamps = false;
    protected $fillable = [
        'data_inicio',
        'data_fim',
        'descricao',
        'situacao',
        'id_paciente',     
        'id_profissional', 
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function profissional(): BelongsTo
    {
        return $this->belongsTo(Profissional::class, 'id_profissional', 'id_profissional');
    }
    
    public function prontuario(): HasOne
    {
        return $this->hasOne(Prontuario::class, 'id_consulta', 'id_consulta');
    }
    
    public function usoMateriais(): HasMany
    {
        return $this->hasMany(UsoMateriaisConsulta::class, 'id_consulta', 'id_consulta');
    }
    
    public function procedimentosRealizados(): HasMany
    {
        return $this->hasMany(ProcedimentoRealizado::class, 'id_consulta', 'id_consulta');
    }
}
