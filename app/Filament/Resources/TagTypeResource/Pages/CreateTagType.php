<?php

namespace App\Filament\Resources\TagTypeResource\Pages;

use App\Filament\Resources\TagTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTagType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = TagTypeResource::class;

    protected static bool $canCreateAnother = false;

    protected function afterCreate(): void
    {
        $language = $this->data['label_language'];

        if($language!=='en'){

            $this->record->setTranslations('label', [$language => $this->record->label]);
            $this->record->forgetTranslation('label', 'en');

            $this->record->setTranslations('description', [$language => $this->record->description]);
            $this->record->forgetTranslation('description', 'en');
        
        }

        $this->record->save();
    }
}
