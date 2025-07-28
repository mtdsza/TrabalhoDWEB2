<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prontuario extends Model
{
    use HasFactory;
    protected $table = 'prontuarios';
    protected $primaryKey = 'id_prontuario';
    public $timestamps = false;
    protected $fillable = [
        'historico_odontologico',
        'tratamentos_anteriores',
        'diagnostico',
        'prescricoes',
        'observacoes',
        'data_registro',
        'id_paciente',
        'id_consulta',
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

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'id_consulta');
    }
}