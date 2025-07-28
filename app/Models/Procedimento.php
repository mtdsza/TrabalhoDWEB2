<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    use HasFactory;
    protected $table = 'procedimentos';
    protected $primaryKey = 'id_procedimento';
    public $timestamps = false;
    protected $fillable = [
        'nome',
        'valor_padrao',
    ];
}