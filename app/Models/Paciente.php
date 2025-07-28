<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';
    public $timestamps = true;
    protected $fillable = [
        'nome',
        'cpf',
        'nascimento',
        'telefone',
        'email',
        'endereco',
    ];

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'id_paciente', 'id_paciente');
    }

    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class, 'id_paciente', 'id_paciente');
    }
}