<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsoMateriaisConsulta extends Model
{
    use HasFactory;
    protected $table = 'uso_materiais_consulta';
    protected $primaryKey = 'id_uso_material';
    public $timestamps = false;
    protected $fillable = [
        'quantidade',
        'data_uso',
        'id_consulta',
        'id_item_estoque',
    ];

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'id_consulta');
    }

    public function itemEstoque(): BelongsTo
    {
        return $this->belongsTo(Estoque::class, 'id_item_estoque', 'id_item_estoque');
    }
}