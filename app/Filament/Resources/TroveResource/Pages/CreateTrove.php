<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentDrafts\Admin\Resources\Pages\Create\Draftable;

class CreateTrove extends CreateRecord
{
    use Draftable;

    protected static string $resource = TroveResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
