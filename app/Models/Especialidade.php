<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Especialidade extends Model
{
    use HasFactory;
    protected $table = 'especialidades';
    protected $primaryKey = 'id_especialidade';
    public $timestamps = false;
    protected $fillable = [
        'nome',
    ];

    public function profissionais(): BelongsToMany
    {
        return $this->belongsToMany(
            Profissional::class,
            'profissional_especialidades',
            'id_especialidade',
            'id_profissional'
        );
    }
}