<?php

namespace App\Filament\Resources\Agendamentos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AgendamentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cliente_id')
                ->label('Cliente')
                ->relationship('cliente', 'nome')
                ->preload()
                ->required()
                ->searchable(),

            // Serviço
            Select::make('servico_id')
                ->label('Serviços')
                ->relationship('servicos', 'nome')
                ->multiple()
                ->preload()
                ->required()
                ->searchable(),

            // Data
            DatePicker::make('data')
                ->label('Data')
                ->required(),

            // Hora
            TimePicker::make('hora')
                ->label('Hora')
                ->seconds(false)
                ->required(),

            // Preço
            TextInput::make('valor')
                ->label('Valor')
                ->numeric()
                ->prefix('R$'),
            
            // Status
            Select::make('status')
                ->label('Status')
                
                ->options([
                    'agendado' => 'Agendado',
                    'confirmado' => 'Confirmado',
                    'concluido' => 'Concluído',
                    'cancelado' => 'Cancelado',
                ]),

            // ✔️ Toggle de promoção
            Toggle::make('is_promocao')
                ->label('É promoção?')
                ->inline(false)
                ->reactive(),

            // ✔️ Select que só aparece quando for promoção
            Select::make('promocao_id')
                ->label('Promoção')
                ->relationship('promocao', 'nome')
                ->preload()
                ->searchable()
                ->visible(fn (callable $get) => $get('is_promocao') === true)
                ->required(fn (callable $get) => $get('is_promocao') === true),

            // Observações
            Textarea::make('observacoes')
                ->label('Observações')
                ->columnSpanFull(),
            ]);
    }
}
