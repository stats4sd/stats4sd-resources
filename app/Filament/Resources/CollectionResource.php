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
use Filament\Resources\Concerns\Translatable;

class CollectionResource extends Resource
{
    use Translatable;
    
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('title')
                                            ->required(),
                        Forms\Components\TextArea::make('description')
                                            ->rows(3)
                                            ->required(),
                        Forms\Components\Checkbox::make('public')
                                            ->label('Should this collection be shared externally?')
                                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Note - leaving this box unticked prevents the collection from appearing in the full collections list. It does NOT prevent the collection from being referenced in a specific page, e.g. the "CRFS Front Page" Collection'),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')->required(),
                        Forms\Components\Hidden::make('uploader_id')
                                            ->default(Auth::user()->id),
                    ]),
                    Forms\Components\Section::make([
                        Forms\Components\Select::make('label_language')
                                            ->label('Language')
                                            ->options(['en' =>'English', 'es' => 'Spanish', 'fr' => 'French'])
                                            ->required(fn(string $operation) => $operation == 'create')
                                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Select the language you are using to create this collection. After the collection has been created, translations for the other languages can be added at any time while in \'Edit Collection\' mode.'),
                    ])
                    ->aside()
                    ->hiddenOn('edit'),
                ])->from('md')
            ])->columns(1);
    }
 
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                                ->wrap(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_image'),
                Tables\Columns\TextColumn::make('user.name')
                                ->label('Curated By')
                                ->sortable(),
                Tables\Columns\IconColumn::make('public')
                                ->boolean()
                                ->sortable()
                                ->trueColor('success')
                                ->falseColor('warning'),
                Tables\Columns\TextColumn::make('troves_count')
                                ->counts('troves')
                                ->label('# Troves')
                                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            // 'view' => Pages\ViewCollection::route('/{record}'),
        ];
    }
}
