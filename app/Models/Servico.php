<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $fillable = [
        'nome',
        'preco',
        'duracao_minutos',
        'descricao',
        
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function promocoes()
    {
        return $this->belongsToMany(Promocao::class, 'promocao_servico')
                    ->withPivot('sessoes')
                    ->withTimestamps();
    }

}
