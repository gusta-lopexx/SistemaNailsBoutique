<?php

namespace App\Filament\Resources\Servicos\Schemas;

use Dom\Text;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServicoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
        ->schema([
            TextInput::make('nome')
                ->label('Nome do serviço')
                ->required()
                ->maxLength(255),

            TextInput::make('preco')
                ->label('Preço')
                ->numeric()
                ->prefix('R$')
                ->nullable(),

            TextInput::make('duracao_minutos')
                ->label('Duração (minutos)')
                ->numeric()
                ->nullable(),

            Textarea::make('descricao')
                ->label('Descrição')
                ->columnSpanFull()
                ->nullable(),
        ]);
    }
}
