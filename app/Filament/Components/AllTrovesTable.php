<?php

namespace App\Filament\Components;

use App\Filament\Resources\CollectionResource;
use App\Filament\Resources\TroveResource;
use App\Models\Trove;
use Filament\Actions\Contracts\HasRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\HasActiveLocaleSwitcher;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\SpatieLaravelTranslatableContentDriver;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AllTrovesTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;
    use EvaluatesClosures;

    use InteractsWithRecord;

    protected static string $resource = CollectionResource::class;

    #[Reactive]
    public string $activeLocale;

    public function render()
    {
        return view('components.all-troves-table');
    }

    /**
     * From ListRecords
     */
    public static function getResource(): string
    {
        return static::$resource;
    }

    public function table(Table $table): Table
    {
        return $table
            ->searchable()
            ->query(fn(): Builder => Trove::query())
            ->heading('All Troves')
            ->columns([
                TextColumn::make('title')->wrap()
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('cover_image')
                    ->collection('cover_image_' . $this->activeLocale),
                TextColumn::make('creation_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Uploader')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->sortable()
                    ->trueColor('success')
                    ->falseColor('warning'),
                TextColumn::make('download_count')
                    ->label('# Downloads')
                    ->sortable(),
            ])
            ->actions([

                Action::make('attach_trove')
                    ->label('Add Trove to Collection')
                    ->color('success')
                    ->icon('heroicon-o-plus')
                    ->visible(fn(Trove $record) => !$record->collections->contains($this->getRecord()))
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Trove $record) {
                        $this->getRecord()->troves()->attach($record);
                        Notification::make()
                            ->title('Trove Added Successfully')
                            ->success()
                            ->send();
                        $this->resetTable();
                    }),
                Action::make('detach_trove')
                    ->icon('heroicon-o-minus')
                    ->color('danger')
                    ->label('Remove Trove from Collection')
                    ->visible(fn(Trove $record) => $record->collections->contains($this->getRecord()))
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Trove $record) {
                        $this->getRecord()->troves()->detach($record);
                        Notification::make()
                            ->title('Trove Removed Successfully')
                            ->success()
                            ->send();
                        $this->resetTable();
                    }),
                Action::make('view_trove')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Trove $record) => TroveResource::getUrl('view', ['record' => $record->id])),
            ])
            ->bulkActions([
                BulkAction::make('attach')
                    ->label('Add Trove(s) to Collection')
                    ->action(fn(\Illuminate\Database\Eloquent\Collection $records) => $this->getRecord()->troves()->syncWithoutDetaching($records)),
            ]);
    }

    /*
     * TRANSLATABLE STUFF
     */

    public function getActiveTableLocale(): ?string
    {
        return $this->activeLocale;
    }

    public function getTranslatableLocales(): array
    {
        return static::getResource()::getTranslatableLocales();
    }

    public function getActiveFormsLocale(): ?string
    {
        if (!in_array($this->activeLocale, $this->getTranslatableLocales())) {
            return null;
        }

        return $this->activeLocale;
    }

    public function getActiveActionsLocale(): ?string
    {
        return $this->activeLocale;
    }

    /**
     * @return class-string<TranslatableContentDriver> | null
     */
    public function getFilamentTranslatableContentDriver(): ?string
    {
        return SpatieLaravelTranslatableContentDriver::class;
    }


}
