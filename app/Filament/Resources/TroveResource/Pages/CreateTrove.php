<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrove extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = TroveResource::class;

    protected static bool $canCreateAnother = false;
    
}
