<?php

namespace App\Filament\Resources\Promocaos\Pages;

use App\Filament\Resources\Promocaos\PromocaoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPromocao extends ViewRecord
{
    protected static string $resource = PromocaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
