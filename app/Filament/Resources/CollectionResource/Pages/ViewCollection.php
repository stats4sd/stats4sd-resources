<?php

namespace App\Filament\Resources\CollectionResource\Pages;

use App\Filament\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\Trove;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ViewCollection extends ViewRecord implements HasTable
{

     use ViewRecord\Concerns\Translatable;
     use InteractsWithTable;

    protected static string $resource = CollectionResource::class;
    protected static string $view = 'filament.pages.view-collection';

    public bool $showAllTroves = false;

    public function getHeading(): string|Htmlable
    {
        return $this->record->title;
    }

    // need to fill-form to get the activeLocale
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


    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Trove::query())
            ->heading('All Troves')
            ->columns([
                TextColumn::make('title')->wrap(),
                SpatieMediaLibraryImageColumn::make('cover_image')
                                ->collection('cover_image'),
                TextColumn::make('creation_date')
                                ->date()
                                ->sortable(),
                TextColumn::make('user.name')
                                ->label('Uploader')
                                ->sortable(),
                IconColumn::make('public')
                                ->boolean()
                                ->sortable()
                                ->trueColor('success')
                                ->falseColor('warning'),
                TextColumn::make('download_count')
                                ->label('# Downloads')
                                ->sortable(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }

}
