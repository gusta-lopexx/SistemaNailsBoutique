<?php

namespace App\Filament\Resources\Agendamentos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use SebastianBergmann\CodeCoverage\Filter;

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
                ->toggleable(),
            
            TextColumn::make('status')
                ->label('Status')
                ->sortable()
                ->toggleable(),

           TextColumn::make('status')
            ->label('Status')
            ->badge()
            ->color(fn ($state) => match ($state) {
                'agendado' => 'warning',
                'confirmado' => 'success',
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
            ])
            ->recordActions([
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
