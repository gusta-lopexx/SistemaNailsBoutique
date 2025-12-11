<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class ReceitaMensalChart extends ChartWidget
{
    protected ?string $heading = 'Receita Mensal';
    protected static ?int $sort = 2;

    /**
     * FILTRO DE MESES
     */
    protected function getFilters(): ?array
    {
        return [
            'jan' => 'Janeiro',
            'fev' => 'Fevereiro',
            'mar' => 'Março',
            'abr' => 'Abril',
            'mai' => 'Maio',
            'jun' => 'Junho',
            'jul' => 'Julho',
            'ago' => 'Agosto',
            'set' => 'Setembro',
            'out' => 'Outubro',
            'nov' => 'Novembro',
            'dez' => 'Dezembro',
        ];
    }

    /**
     * GERAR DADOS DO GRÁFICO
     */
    protected function getData(): array
    {
        // mapa de meses
        $monthMap = [
            'jan' => 1, 'fev' => 2, 'mar' => 3, 'abr' => 4,
            'mai' => 5, 'jun' => 6, 'jul' => 7, 'ago' => 8,
            'set' => 9, 'out' => 10, 'nov' => 11, 'dez' => 12,
        ];

        $selectedMonth = $this->filter
            ? ($monthMap[$this->filter] ?? now()->month)
            : now()->month;

        $year = now()->year;

        // buscar agendamentos concluídos com serviços e promoção
        $agendamentos = Agendamento::query()
            ->whereMonth('data', $selectedMonth)
            ->whereYear('data', $year)
            ->where('status', 'concluido')
            ->with(['servicos', 'promocao'])
            ->get();

        /**
         * AGRUPAR RECEITA POR DIA
         */
        $receitasPorDia = $agendamentos
            ->groupBy(fn($ag) => Carbon::parse($ag->data)->day)
            ->map(function ($items) {

                $totalDia = 0;

                foreach ($items as $agendamento) {

                    // Se tiver promoção → usa o valor da promoção
                    if ($agendamento->promocao) {
                        $totalDia += (float) $agendamento->promocao->valor;
                        continue;
                    }

                    // Sem promoção → somar preços dos serviços
                    foreach ($agendamento->servicos as $servico) {
                        $totalDia += (float) ($servico->preco ?? 0);
                    }
                }

                return $totalDia;
            })
            ->toArray();

        /**
         * GERAR LABELS E VALORES DO GRÁFICO
         */
        $diasMes = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $year);

        $labels = range(1, $diasMes);
        $values = [];

        foreach ($labels as $dia) {
            $values[] = $receitasPorDia[$dia] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receita (R$)',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
