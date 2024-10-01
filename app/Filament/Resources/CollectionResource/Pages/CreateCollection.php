<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCollection extends CreateRecord
{

    protected static string $resource = CollectionResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return CollectionResource::getUrl('view', ['record' => $this->record]);
    }

}
