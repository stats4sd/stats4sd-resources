<?php

namespace App\Filament\Resources\TroveResource\Pages;

use App\Filament\Resources\TroveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrove extends CreateRecord
{
    // temp
    protected static string $view = 'filament.pages.create-record';

    protected static string $resource = TroveResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        //$data['title'] = 'titles added after creation';
        $data['description'] = 'descriptions added after creation';

        return $data;
    }

    protected function afterCreate(): void
    {
       // $this->record->title = '';
        $this->record->description = '';

//        if(!is_null($this->data['title_en'])) {$this->record->setTranslation('title', 'en', $this->data['title_en']);}
//        if(!is_null($this->data['title_es'])) {$this->record->setTranslation('title', 'es', $this->data['title_es']);}
//        if(!is_null($this->data['title_fr'])) {$this->record->setTranslation('title', 'fr', $this->data['title_fr']);}

        if(!is_null($this->data['description_en'])) {$this->record->setTranslation('description', 'en', $this->data['description_en']);}
        if(!is_null($this->data['description_es'])) {$this->record->setTranslation('description', 'es', $this->data['description_es']);}
        if(!is_null($this->data['description_fr'])) {$this->record->setTranslation('description', 'fr', $this->data['description_fr']);}

        $this->record->setTranslation('external_links', 'en', $this->data['external_links_en']);
        $this->record->setTranslation('external_links', 'es', $this->data['external_links_es']);
        $this->record->setTranslation('external_links', 'fr', $this->data['external_links_fr']);

        $this->record->setTranslation('youtube_links', 'en', $this->data['youtube_links_en']);
        $this->record->setTranslation('youtube_links', 'es', $this->data['youtube_links_es']);
        $this->record->setTranslation('youtube_links', 'fr', $this->data['youtube_links_fr']);

        $this->record->save();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
