<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocao extends Model
{
    protected $table = 'promocoes';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'valor',
        'descricao',
    ];

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'promocao_servico')
                    ->withPivot('sessoes')
                    ->withTimestamps();
    }

}
