<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages\ViewCollection;
use App\Filament\Translatable\Form\TranslatableComboField;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
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
use Illuminate\Support\HtmlString;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

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

                Section::make('cover_image')
                    ->icon('heroicon-o-photo')
                    ->iconColor('primary')
                    ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                    ->heading(__('Cover Image'))
                    ->description(__('Add a cover image for the resource. This will be displayed on the front-end.'))
                    ->columns(3)
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_en')
                            ->label('English')
                            ->collection('cover_image_en')
                            ->disk('s3'),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_es')
                            ->label('Spanish')
                            ->collection('cover_image_es')
                            ->disk('s3'),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_fr')
                            ->label('French')
                            ->collection('cover_image_fr')
                            ->disk('s3'),
                    ]),

            ])->columns(1);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->wrap(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_image')
                    ->collection(fn(Pages\ListCollections $livewire) => 'cover_image_' . $livewire->activeLocale)
                    ->action(
                        Tables\Actions\Action::make('view_image')
                            ->modalHeading(fn(Collection $record, Pages\ListCollections $livewire) => $record->title . ' - Cover Image (' . $livewire->activeLocale . ')')
                            ->modalContent(fn(Collection $record, Pages\ListCollections $livewire) => new HtmlString('<img src="' . $record->getFirstMediaUrl('cover_image_' . $livewire->activeLocale) . '" class="w-full h-auto">'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    ),
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
                CommentsAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewCollection::route('/{record}'),
        ];
    }
}
