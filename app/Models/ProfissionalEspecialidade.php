<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfissionalEspecialidade extends Model
{
    use HasFactory;
    protected $table = 'profissional_especialidades';
    protected $primaryKey = 'id_profissional_especialidade';
    public $timestamps = false;
}