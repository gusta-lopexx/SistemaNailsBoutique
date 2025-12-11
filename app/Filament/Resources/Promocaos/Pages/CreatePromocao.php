<?php

namespace App\Filament\Resources\Promocaos\Pages;

use App\Filament\Resources\Promocaos\PromocaoResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePromocao extends CreateRecord
{
    protected static string $resource = PromocaoResource::class;

    protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }

}
