<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCollection extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = CollectionResource::class;

    protected static bool $canCreateAnother = false;

    protected function afterCreate(): void
    {
        $language = $this->data['label_language'];

        if($language!=='en'){

            $this->record->setTranslations('title', [$language => $this->record->title]);
            $this->record->forgetTranslation('title', 'en');

            $this->record->setTranslations('description', [$language => $this->record->description]);
            $this->record->forgetTranslation('description', 'en');
        
        }

        $this->record->save();
    }

}
