<?php

namespace App\Filament\Resources\Promocaos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PromocaosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->label('Promoção')->searchable(),
                TextColumn::make('valor')->label('Valor')->money('BRL'),
                TextColumn::make('data_inicio')->label('Início')->date('d/m/Y'),
                TextColumn::make('data_fim')->label('Fim')->date('d/m/Y'),
                TextColumn::make('created_at')->label('Criado em')->date('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
