<?php

namespace App\Filament\Resources\TroveTypeResource\Pages;

use App\Filament\Resources\TroveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTroveType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    
    protected static string $resource = TroveTypeResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['label'] = 'labels added after creation';
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->label = '';

        if(!is_null($this->data['label_en'])){
            $this->record->setTranslation('label', 'en', $this->data['label_en']);
        }

        if(!is_null($this->data['label_es'])){
            $this->record->setTranslation('label', 'es', $this->data['label_es']);
        }

        if(!is_null($this->data['label_fr'])){
            $this->record->setTranslation('label', 'fr', $this->data['label_fr']);
        }

        $this->record->save();
    }

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

}
