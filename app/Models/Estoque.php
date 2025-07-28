<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $table = 'estoque';
    protected $primaryKey = 'id_item_estoque';
    public $timestamps = false;
    protected $fillable = [
        'descricao', 
        'quantidade', 
        'estoque_min', 
    ];
}