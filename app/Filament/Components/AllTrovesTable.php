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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
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
            ->headerActions([
                Action::make('hide_all_troves')
                    ->label('Show Troves in Collection')
                    ->action(fn(Component $livewire) => $livewire->dispatch('hideAllTroves')),
            ])
            ->query(fn(): Builder => Trove::query())
            ->heading('All Troves')
            ->description('Select Troves to add to this Collection')
            ->columns(TroveResource::getTableColumns())
            ->filters(TroveResource::getTableFilters())
            ->filtersTriggerAction(fn($action) => $action->button()->label('Filters'))
            ->filtersLayout(fn() => FiltersLayout::AboveContentCollapsible)
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
                Action::make('preview_trove')
                    ->label('Preview Trove')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Trove $record) => config('app.front_end_url') . '/resources/' . $record->slug),
            ])
            ->recordUrl(fn(Trove $record) => config('app.front_end_url') . '/resources/' . $record->slug)
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
