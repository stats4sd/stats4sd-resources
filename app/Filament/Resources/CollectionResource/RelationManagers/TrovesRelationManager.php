<?php

namespace App\Filament\Resources\CollectionResource\RelationManagers;

use App\Filament\Resources\TroveResource;
use App\Models\Trove;
use App\Models\TroveType;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class TrovesRelationManager extends RelationManager
{
    use Translatable;

    #[Reactive]
    public ?string $activeLocale = null;

    protected static string $relationship = 'troves';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    /**
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->searchable()
            ->heading('Troves in this Collection')
            ->columns(TroveResource::getTableColumns())
            ->filters(TroveResource::getTableFilters())
            ->filtersTriggerAction(fn($action) => $action->button()->label('Filters'))
            ->filtersLayout(fn() => FiltersLayout::AboveContentCollapsible)
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\Action::make('preview_trove')
                    ->label('Preview Trove')
                    ->url(fn(Trove $record) => config('app.front_end_url') . '/resources/' . $record->slug),
                Tables\Actions\DetachAction::make()
                    ->label('Remove trove from collection')
                    ->modalHeading('Remove trove from collection')
                    ->successNotificationTitle('Trove removed from collection'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make()->label('Remove troves from collection'),
                ]),
            ])
            ->recordUrl(fn(Trove $record) => config('app.front_end_url') . '/resources/' . $record->slug)
            ->emptyStateDescription(
                'Use the "Show All Troves" button above to find troves to add to the collection.'
            );
    }
}
