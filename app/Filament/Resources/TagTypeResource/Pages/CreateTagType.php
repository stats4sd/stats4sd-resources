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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['label'] = 'labels added after creation';
        $data['description'] = 'descriptions added after creation';
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->label = '';
        $this->record->description = '';

        if(!is_null($this->data['label_en'])){
            $this->record->setTranslation('label', 'en', $this->data['label_en']);
        }

        if(!is_null($this->data['label_es'])){
            $this->record->setTranslation('label', 'es', $this->data['label_es']);
        }

        if(!is_null($this->data['label_fr'])){
            $this->record->setTranslation('label', 'fr', $this->data['label_fr']);
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

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
