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
    
    protected function afterCreate(): void
    {
        $language = $this->data['label_language'];

        if($language!=='en'){

            $this->record->setTranslations('title', [$language => $this->record->title]);
            $this->record->forgetTranslation('title', 'en');

            $this->record->setTranslations('description', [$language => $this->record->description]);
            $this->record->forgetTranslation('description', 'en');

            $this->record->setTranslations('youtube_links', [$language => $this->record->youtube_links]);
            $this->record->forgetTranslation('youtube_links', 'en');

            $this->record->setTranslations('external_links', [$language => $this->record->external_links]);
            $this->record->forgetTranslation('external_links', 'en');
        
        }

        $this->record->save();
    }

}
