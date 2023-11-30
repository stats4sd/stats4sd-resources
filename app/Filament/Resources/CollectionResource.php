<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Trove;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Wizard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollectionResource\Pages;
use App\Filament\Resources\CollectionResource\RelationManagers;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                                    ->required(),
                Forms\Components\TextInput::make('description')
                                    ->required(),
                Forms\Components\Checkbox::make('public')
                                    ->label('Should this collection be shared externally?')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Note - leaving this box unticked prevents the collection from appearing in the full collections list. It does NOT prevent the collection from being referenced in a specific page, e.g. the "CCRP Front Page" Collection'),
                Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')->required(),
                Forms\Components\Hidden::make('uploader_id')
                                    ->default(Auth::user()->id),
            ])->columns(1);
                        // ->schema([
                        //     Forms\Components\Select::make('troves')
                        //     ->multiple()
                        //     ->label('Add resource troves to this collection')
                        //     ->placeholder('Select a resource trove')
                        //     ->options(Trove::all()->pluck('title', 'id'))
                        //     ->required()
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                                ->wrap(),
                // Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_image'),
                Tables\Columns\TextColumn::make('user.name')
                                ->label('Uploader')
                                ->sortable(),
                Tables\Columns\IconColumn::make('public')
                                ->boolean()
                                ->sortable()
                                ->trueColor('success')
                                ->falseColor('warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TrovesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
            'view' => Pages\ViewCollection::route('/{record}'),
        ];
    }
}
