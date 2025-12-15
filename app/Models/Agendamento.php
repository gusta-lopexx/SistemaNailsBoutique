<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'cliente_id',
        'servico_id',
        'data',
        'hora',
        'valor',
        'is_promocao',
        'promocao_id',
        'status',        
        'observacoes',
        'is_sessao',
        'total_sessoes',
        'sessao_atual',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'agendamento_servico');
    }

    public function promocao()
    {
        return $this->belongsTo(Promocao::class);
    }
}
