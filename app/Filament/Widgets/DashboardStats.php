<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use App\Models\Cliente;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class DashboardStats extends BaseWidget
{
    protected static ?int $sort = -10;

    protected function getStats(): array
    {
        $hoje = Carbon::today();
        $mesAtual = Carbon::now()->month;

        // Quantidade de atendimentos no mês
        $atendimentosMes = Agendamento::whereMonth('data', $mesAtual)->count();

        // Valor total recebido no mês
        $valorMes = Agendamento::whereMonth('data', now()->month)
            ->whereYear('data', now()->year)
            ->where('status', 'concluido')
            ->get()
            ->sum(function ($agendamento) {

                // 🟡 Sessões de combo: só a primeira gera valor
                if ($agendamento->is_sessao && $agendamento->sessao_atual > 1) {
                    return 0;
                }

                // 🟢 Promoção
                if ($agendamento->promocao) {
                    return (float) $agendamento->promocao->valor;
                }

                // 🔵 Valor normal do agendamento
                return (float) $agendamento->valor;
            });



        // Quantidade de clientes cadastrados
        $totalClientes = Cliente::count();

        // Quantidade de atendimentos hoje
        $atendimentosHoje = Agendamento::whereDate('data', $hoje)->count();

        return [
            Stat::make('Atendimentos no mês', $atendimentosMes)
                ->description('Total de agendamentos deste mês')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make('Entrada no mês', 'R$ ' . number_format($valorMes, 2, ',', '.'))
                ->description('Valor total de serviços')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Clientes cadastrados', $totalClientes)
                ->description('Total geral')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('warning'),

            Stat::make('Atendimentos hoje', $atendimentosHoje)
                ->description('Agendamentos do dia')
                ->descriptionIcon('heroicon-o-clock')
                ->color('info'),
        ];
    }
}
