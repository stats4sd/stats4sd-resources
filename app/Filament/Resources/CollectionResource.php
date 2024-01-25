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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Title')
                                ->description('Add a useful title for the collection.')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('title')->hiddenOn(['edit', 'create']),
                                    Forms\Components\TextInput::make('title_en')
                                                    ->label('English')
                                                    ->requiredWithoutAll('title_es, title_fr')
                                                    ->validationMessages(['required_without_all' => 'Enter the title in at least one language']),
                                    Forms\Components\TextInput::make('title_es')
                                                    ->label('Spanish')
                                                    ->requiredWithoutAll('title_en, title_fr')
                                                    ->validationMessages(['required_without_all' => 'Enter the title in at least one language']),
                                    Forms\Components\TextInput::make('title_fr')
                                                    ->label('French')
                                                    ->requiredWithoutAll('title_es, title_en')
                                                    ->validationMessages(['required_without_all' => 'Enter the title in at least one language']),
                                ]),
                
                Forms\Components\Section::make('Description')
                                ->description('For example: What is this collection? Who is it for? Why was it curated?')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('description')->hiddenOn(['edit', 'create']),
                                    Forms\Components\TextArea::make('description_en')
                                                    ->label('English')
                                                    ->requiredWithoutAll('description_es, description_fr')
                                                    ->validationMessages(['required_without_all' => 'Enter the description in at least one language']),
                                    Forms\Components\TextArea::make('description_es')
                                                    ->label('Spanish')
                                                    ->requiredWithoutAll('description_en, description_fr')
                                                    ->validationMessages(['required_without_all' => 'Enter the description in at least one language']),
                                    Forms\Components\TextArea::make('description_fr')
                                                    ->label('French')
                                                    ->requiredWithoutAll('description_es, description_en')
                                                    ->validationMessages(['required_without_all' => 'Enter the description in at least one language']),
                                ]),


                Forms\Components\Checkbox::make('public')
                                ->label('Should this collection be shared externally?')
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Note - leaving this box unticked prevents the collection from appearing in the full collections list. It does NOT prevent the collection from being referenced in a specific page, e.g. the "CRFS Front Page" Collection'),
                
                Forms\Components\Fieldset::make('cover_image')
                                ->label('Cover Image')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_en')
                                                        ->label('English')
                                                        ->collection('collection_cover_en'),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_es')
                                                        ->label('Spanish')
                                                        ->collection('collection_cover_es'),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_fr')
                                                        ->label('French')
                                                        ->collection('collection_cover_fr'),
                                ]),
                
                Forms\Components\Hidden::make('uploader_id')
                                            ->default(Auth::user()->id),



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
