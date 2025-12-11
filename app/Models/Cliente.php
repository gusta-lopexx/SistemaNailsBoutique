<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone',
        'anotacoes',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
