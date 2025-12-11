<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(20),

                TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel()
                    ->maxLength(255),

                Textarea::make('anotacoes')
                    ->label('Observações')
                    ->columnSpanFull(),
            ]);
    }
}
