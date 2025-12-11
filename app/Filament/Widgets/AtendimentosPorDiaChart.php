<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class AtendimentosPorDiaChart extends ChartWidget
{
    protected ?string $heading = 'Atendimentos por Dia';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $dias = collect();
        $counts = collect();

        for ($i = 14; $i >= 0; $i--) {
            $dia = Carbon::today()->subDays($i)->format('Y-m-d');

            $dias->push(Carbon::parse($dia)->format('d/m'));
            $counts->push(
                Agendamento::whereDate('data', $dia)->count()
            );
        }

        return [
            'labels' => $dias->toArray(),
            'datasets' => [
                [
                    'label' => 'Atendimentos',
                    'data' => $counts->toArray(),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
