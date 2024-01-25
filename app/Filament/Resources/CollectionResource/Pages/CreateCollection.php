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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['title'] = 'titles added after creation';
        $data['description'] = 'descriptions added after creation';
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->title = '';
        $this->record->description = '';

        if(!is_null($this->data['title_en'])){
            $this->record->setTranslation('title', 'en', $this->data['title_en']);
        }

        if(!is_null($this->data['title_es'])){
            $this->record->setTranslation('title', 'es', $this->data['title_es']);
        }

        if(!is_null($this->data['title_fr'])){
            $this->record->setTranslation('title', 'fr', $this->data['title_fr']);
        }

        if(!is_null($this->data['description_en'])){
            $this->record->setTranslation('description', 'en', $this->data['description_en']);
        }

        if(!is_null($this->data['description_es'])){
            $this->record->setTranslation('description', 'es', $this->data['description_es']);
        }

        if(!is_null($this->data['description_fr'])){
            $this->record->setTranslation('description', 'fr', $this->data['description_fr']);
        }

        $this->record->save();
    }

}
