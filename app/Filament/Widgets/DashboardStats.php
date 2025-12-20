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
        $anoAtual = Carbon::now()->year;

        // 📌 Atendimentos no mês (não cancelados)
        $atendimentosMes = Agendamento::whereMonth('data', $mesAtual)
            ->whereYear('data', $anoAtual)
            ->whereIn('status', ['agendado', 'confirmado', 'concluido'])
            ->count();

        // 💰 Valor total recebido no mês (somente concluídos)
        $valorMes = Agendamento::whereMonth('data', $mesAtual)
            ->whereYear('data', $anoAtual)
            ->where('status', 'concluido')
            ->get()
            ->sum(function ($agendamento) {

                // 🟡 Sessão de combo → só a primeira gera valor
                if ($agendamento->is_sessao && $agendamento->sessao_atual > 1) {
                    return 0;
                }

                // 🟢 Promoção
                if ($agendamento->promocao) {
                    return (float) $agendamento->promocao->valor;
                }

                // 🔵 Valor normal
                return (float) $agendamento->valor;
            });

        // 👥 Clientes cadastrados
        $totalClientes = Cliente::count();

        // ⏰ Atendimentos hoje (sem cancelados)
        $atendimentosHoje = Agendamento::whereDate('data', $hoje)
            ->whereIn('status', ['agendado', 'confirmado', 'concluido'])
            ->count();

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
