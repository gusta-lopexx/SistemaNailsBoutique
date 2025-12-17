<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use Filament\Widgets\TableWidget;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;

class ProximosAgendamentos extends TableWidget
{
    protected static ?string $heading = 'Próximos Agendamentos';
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Agendamento::query()
                    ->whereDate('data', '>=', now())
                    ->orderBy('data')
                    ->orderBy('hora')
            )
            ->columns([
                Tables\Columns\TextColumn::make('data')
                    ->label('Data')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('hora')
                    ->label('Hora'),

                Tables\Columns\TextColumn::make('cliente.nome')
                    ->label('Cliente'),

                Tables\Columns\TextColumn::make('valor')
                    ->label('Valor')
                    ->money('BRL'),
            ])
            ->paginated(false); // mostra só os próximos 10
    }
}
