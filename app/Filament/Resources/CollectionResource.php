<?php

namespace App\Filament\Resources;

use App\Filament\Translatable\Form\TranslatableComboField;
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

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableComboField::make('title')
                    ->icon('heroicon-o-exclamation-circle')
                    ->iconColor('primary')
                    ->extraAttributes(['style' => 'background-color: #e6e6e6;'])
                    ->label('Collection Title')
                    ->description('Add a useful title for the collection.')
                    ->columns(3)
                    ->childField(Forms\Components\TextInput::class)
                    ->required(),

                TranslatableComboField::make('description')
                    ->icon('heroicon-o-document-text')
                    ->iconColor('primary')
                    ->extraAttributes(['style' => 'background-color: #e6e6e6;'])
                    ->label('Describe the Collection')
                    ->description('For example: What is this collection? Who is it for? Why was it curated?')
                    ->childField(Forms\Components\MarkdownEditor::class)
                    ->required(),

                TranslatableComboField::make('cover_image')
                    ->icon('heroicon-o-photo')
                    ->iconColor('primary')
                    ->extraAttributes(['style' => 'background-color: #e6e6e6;'])
                    ->label('Cover Image')
                    ->description('Add  a cover image, which will be displayed on the collection page.')
                    ->columns(3)
                    ->childField(
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')
                            ->collection('collection_cover'),
                    )
                    ->required(),

                Forms\Components\Section::make('Visibility')
                    ->icon('heroicon-o-eye')
                    ->iconColor('primary')
                    ->extraAttributes(['style' => 'background-color: #e6e6e6;'])
                    ->columns(3)
                    ->schema([
                        Forms\Components\Checkbox::make('public')
                            ->label('Should this collection be shared externally?')
                            ->hintIcon(
                                icon: 'heroicon-m-question-mark-circle',
                                tooltip: 'Note - leaving this box unticked prevents the collection from appearing in the full collections list. It does NOT prevent the collection from being referenced in a specific page, e.g. the "CRFS Front Page" Collection'),
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
