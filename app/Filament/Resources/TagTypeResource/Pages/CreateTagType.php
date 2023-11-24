<?php

namespace App\Filament\Resources\TagTypeResource\Pages;

use App\Filament\Resources\TagTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTagType extends CreateRecord
{
    protected static string $resource = TagTypeResource::class;

    protected static bool $canCreateAnother = false;
}
