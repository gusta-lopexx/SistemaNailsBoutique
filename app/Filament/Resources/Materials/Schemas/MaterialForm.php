<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                ->label('Nome do material')
                ->required()
                ->maxLength(255),

                TextInput::make('quantidade')
                    ->label('Quantidade em estoque')
                    ->numeric()
                    ->default(0),

                TextInput::make('unidade')
                    ->label('Unidade (ml, g, un)')
                    ->maxLength(10)
                    ->nullable(),

                TextInput::make('custo')
                    ->label('Custo (R$)')
                    ->numeric()
                    ->prefix('R$')
                    ->nullable(),

                Textarea::make('descricao')
                    ->label('Descrição')
                    ->columnSpanFull(),
            ]);
    }
}
