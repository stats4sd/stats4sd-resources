<?php

namespace App\Filament\Resources;

use App\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Tag;
use App\Models\Trove;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\TroveResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TroveResource\RelationManagers;
use Filament\Resources\Concerns\Translatable;

class TroveResource extends Resource
{
    use Translatable;
    
    protected static ?string $model = Trove::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Details')
                        ->icon('heroicon-m-information-circle')
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                                ->required()
                                                ->label('Title')
                                                ->helperText('Add a useful title for the resource, this could be the title of the document, or the name of the software, etc.'),

                            Forms\Components\MarkdownEditor::make('description')
                                                ->required()
                                                ->helperText('For example: What is this trove? Who is it for? Why was it or uploaded?'),

                            Forms\Components\Select::make('trove_type_id')
                                                ->placeholder('Select the resource type')
                                                ->relationship('troveType', 'label')
                                                ->required()
                                                ->getOptionLabelFromRecordUsing(fn($record, $livewire) => $record->getTranslation('label', 'en')),

                            Forms\Components\Select::make('source')
                                                ->placeholder('Select the origin of the resource')
                                                ->options([0 => 'Internal', 1 => 'External'])
                                                ->required(),

                            Forms\Components\DatePicker::make('creation_date')
                                                ->label('When was the resource created?')
                                                ->helperText('To the nearest month (approximately is fine). This is mainly to highlight to users when a resource might be a bit out of date.')
                                                ->required(),

                            Forms\Components\Hidden::make('uploader_id')->default(Auth::user()->id),
                        ]),
                    Wizard\Step::make('Tags')
                        ->icon('heroicon-m-tag')
                        ->schema([
                            Forms\Components\SpatieTagsInput::make('tags')
                                                ->placeholder('Add tags')
                                                ->label('Select tags')
                                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Except where specified, you must select from existing tags. If you believe a new tag is required, please contact Emily. You can apply as many tags as you need for each category.')
                                                ->helperText('These tags help organise and filter the resources on the front-end. ')
                                                ->required()
                        ]),
                    Wizard\Step::make('Content')
                        ->icon('heroicon-m-link')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('files')
                                                ->label('Files')
                                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: ('A trove will often contain multiple files. These are files that work together, for example a questions and answers sheet, or a document translated into different languages.'))
                                                ->helperText('One or more files can be uploaded into this resource trove')
                                                ->multiple()
                                                ->enableReordering()
                                                ->collection('content'),
                            Forms\Components\Repeater::make('external_links')
                                                ->label('External links - websites, files etc., hosted by other people')
                                                ->schema([
                                                    Forms\Components\TextInput::make('link_title'),
                                                    Forms\Components\TextInput::make('link_url')
                                                                        ->label('Link URL')
                                                ])
                                                ->columns(2)
                                                ->addActionLabel('Add another link'),
                            Forms\Components\Repeater::make('youtube_links')
                                                ->label('YouTube Videos (if you have added a video file that already exists on YouTube)')
                                                ->schema([
                                                    Forms\Components\TextInput::make('youtube_id')
                                                                        ->label('YouTube id')
                                                                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'In YouTube, when you hit "share", the id is the random-like string after <strong>https://youtu.be/</strong>'),
                                                ])
                                                ->addActionLabel('Add another YouTube video'),
                        ]),
                    Wizard\Step::make('Cover Image')
                        ->icon('heroicon-m-photo')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')
                                                ->label('Cover image')
                                                ->collection('cover_image'),
                        ]),
                    Wizard\Step::make('Check')
                        ->icon('heroicon-m-clipboard-document-check')
                        ->schema([
                            Placeholder::make('check_info')
                                ->disableLabel()
                                ->content(new HtmlString('Checking section')),
                            Forms\Components\Checkbox::make('public')
                                ->label('Is this trove resource ready to be shared externally?')
                        ]),
                ])
                ->skippable()
                // ->submitAction(new HtmlString('<button type="submit">Submit</button>'))
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                                ->wrap(),
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
                SelectFilter::make('source')
                    ->options([0 => 'Internal', 1 => 'External']),
                SelectFilter::make('resourceType')
                    ->relationship('troveType', 'label')
                    ->getOptionLabelFromRecordUsing(fn($record, $livewire) => $record->getTranslation('label', 'en')),
                SelectFilter::make('uploader')
                    ->relationship('user', 'name')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTroves::route('/'),
            'create' => Pages\CreateTrove::route('/create'),
            'edit' => Pages\EditTrove::route('/{record}/edit'),
        ];
    }
}
