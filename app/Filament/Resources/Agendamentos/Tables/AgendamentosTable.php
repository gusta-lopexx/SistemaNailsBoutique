<?php

namespace App\Filament\Resources\Agendamentos\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use SebastianBergmann\CodeCoverage\Filter;
use Filament\Tables\Columns\Summarizers\Sum;


class AgendamentosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente.nome')
                ->label('Cliente')
                ->searchable()
                ->sortable()
                ->toggleable(),

            TextColumn::make('servicos.nome')
                ->label('Serviço')
                ->sortable()
                ->toggleable(),

            TextColumn::make('data')
                ->label('Data')
                ->date('d/m/Y')
                ->sortable()
                ->toggleable(),

            TextColumn::make('hora')
                ->label('Hora')
                ->sortable()
                ->toggleable(),
            
            TextColumn::make('sessao_atual')
                ->label('Sessão')
                ->formatStateUsing(fn ($record) =>
                    $record->is_sessao
                        ? "{$record->sessao_atual} / {$record->total_sessoes}"
                        : '-'
                )
                ->toggleable(),


            TextColumn::make('valor')
                ->label('Valor')
                ->money('BRL')
                ->toggleable()
                ->summarize(
                    Sum::make()
                        ->label('Total')
                        ->money('BRL')
                ),
            
            TextColumn::make('status')
                ->label('Status')
                ->sortable()
                ->toggleable(),

           TextColumn::make('status')
            ->label('Status')
            ->badge()
            ->color(fn ($state) => match ($state) {
                'agendado' => 'warning',
                'confirmado' => 'info',
                'concluido' => 'success',
                'cancelado' => 'danger',
                default => 'secondary',
            }),

            TextColumn::make('created_at')
                ->label('Criado em')
                ->date('d/m/Y H:i')
                ->toggleable(),

            TextColumn::make('updated_at')
                ->label('Atualizado em')
                ->date('d/m/Y H:i')
                ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('data')
                ->label('Período')
                ->form([
                    DatePicker::make('data_inicial')->label('Data inicial'),
                    DatePicker::make('data_final')->label('Data final'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['data_inicial'] ?? null, fn ($q, $date) =>
                            $q->where('data', '>=', $date)
                        )
                        ->when($data['data_final'] ?? null, fn ($q, $date) =>
                            $q->where('data', '<=', $date)
                        );
                }),

                SelectFilter::make('status')
                    ->label('Status')
                    ->multiple() // 👈 permite selecionar mais de um
                    ->options([
                        'agendado' => 'Agendado',
                        'confirmado' => 'Confirmado',
                        'concluido' => 'Concluído',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default(['agendado', 'confirmado']),              


            ])
            ->recordActions([
                Action::make('concluir')
                    ->label('Concluir')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status !== 'concluido')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'concluido',
                        ]);
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
