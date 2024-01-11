<?php

namespace App\Filament\Resources\CollectionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class TrovesRelationManager extends RelationManager
{
    use Translatable;

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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->wrap(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_image')
                                ->collection('cover_image'),
                Tables\Columns\TextColumn::make('creation_date')
                                ->date()
                                ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                                ->label('Uploader')
                                ->sortable(),
                Tables\Columns\IconColumn::make('public')
                                ->boolean()
                                ->sortable()
                                ->trueColor('success')
                                ->falseColor('warning'),
                Tables\Columns\TextColumn::make('download_count')
                                ->label('# Downloads')
                                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\LocaleSwitcher::make(),
                Tables\Actions\AttachAction::make()
                                ->label('Attach troves to collection')
                                ->preloadRecordSelect()
                                ->recordSelect(
                                    fn (Select $select) => $select->placeholder('Select a trove'),
                                )
                                ->modalHeading('Attach trove to collection')
                                ->successNotificationTitle('Trove attached to collection')
])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            ]);
    }
}
