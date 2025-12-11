<?php

namespace App\Filament\Widgets;

use App\Models\Servico;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RankingServicosChart extends ChartWidget
{
    protected ?string $heading = 'Serviços Mais Realizados';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'Medium';

    protected function getData(): array
    {
        $dados = DB::table('agendamento_servico')
            ->join('servicos', 'servicos.id', '=', 'agendamento_servico.servico_id')
            ->select('servicos.nome', DB::raw('COUNT(*) as total'))
            ->groupBy('servicos.nome')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return [
            'labels' => $dados->pluck('nome'),
            'datasets' => [
                [
                    'label' => 'Quantidade',
                    'data' => $dados->pluck('total'),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
