<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'login',
        'email',
        'password',
        'tipo',
        'id_profissional',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profissional(): BelongsTo
    {
        return $this->belongsTo(Profissional::class, 'id_profissional');
    }
}