<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTroveType extends CreateRecord
{
    protected static string $resource = TroveTypeResource::class;

    protected static bool $canCreateAnother = false;
}
