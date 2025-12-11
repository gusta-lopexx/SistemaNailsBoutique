<?php

namespace App\Filament\Resources\Promocaos;

use App\Filament\Resources\Promocaos\Pages\CreatePromocao;
use App\Filament\Resources\Promocaos\Pages\EditPromocao;
use App\Filament\Resources\Promocaos\Pages\ListPromocaos;
use App\Filament\Resources\Promocaos\Pages\ViewPromocao;
use App\Filament\Resources\Promocaos\Schemas\PromocaoForm;
use App\Filament\Resources\Promocaos\Schemas\PromocaoInfolist;
use App\Filament\Resources\Promocaos\Tables\PromocaosTable;
use App\Models\Promocao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PromocaoResource extends Resource
{
    protected static ?string $model = Promocao::class;
    protected static ?string $label = 'Promoção';
    protected static ?string $pluralLabel = 'Promoções';

    protected static string|\UnitEnum|null $navigationGroup = 'Cadastros';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckBadge;

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return PromocaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromocaosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromocaos::route('/'),
            'create' => CreatePromocao::route('/create'),
            'view' => ViewPromocao::route('/{record}'),
            'edit' => EditPromocao::route('/{record}/edit'),
        ];
    }
}
