<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use App\Models\Collection;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewCollection extends ViewRecord
{

    use ViewRecord\Concerns\Translatable;


    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->fillForm();
    }

    // Infolist definition here so we can use "$this" to get the activeLocale. (Doesn't work on Resource for some reason)
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(2)
            ->schema([
                SpatieMediaLibraryImageEntry::make('cover_image')
                    ->hiddenLabel()
                    ->collection(fn(ViewCollection $livewire) => 'cover_image_' . $this->activeLocale)
                    ->disk('s3')
                    ->width('500px')
                    ->height('auto'),
                TextEntry::make('description'),
            ]);
    }


    protected static string $resource = CollectionResource::class;

    public function getHeading(): string|Htmlable
    {
        return $this->record->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }

}
