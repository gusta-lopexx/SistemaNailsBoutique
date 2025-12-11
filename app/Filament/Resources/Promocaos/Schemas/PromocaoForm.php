<?php

namespace App\Filament\Resources\Promocaos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PromocaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                ->label('Nome da promoção')
                ->required(),

            TextInput::make('valor')
                ->label('Valor (R$)')
                ->numeric()
                ->prefix('R$')
                ->required(),

            DatePicker::make('data_inicio')
                ->label('Início')
                ->required(),

            DatePicker::make('data_fim')
                ->label('Fim')
                ->required(),

            Textarea::make('descricao')
                ->label('Descrição')
                ->columnSpanFull(),

            // serviços dentro da promoção
            Repeater::make('servicos')
                ->label('Serviços incluídos')
                ->schema([
                    Select::make('servico_id')
                        ->label('Serviço')
                        ->relationship('servicos', 'nome')
                        ->preload()
                        ->searchable()
                        ->required(),

                    TextInput::make('sessoes')
                        ->label('Quantidade de sessões')
                        ->numeric()
                        ->default(1)
                        ->required(),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->createItemButtonLabel('Adicionar serviço'),
            ]);
    }
}
