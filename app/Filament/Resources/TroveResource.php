<?php

namespace App\Filament\Resources;

use App\User;
use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use App\Models\Trove;
use App\Models\TagType;
use Filament\Forms\Form;
use Filament\Tables\Table;
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
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\TroveResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TroveResource\RelationManagers;

class TroveResource extends Resource
{
    use Translatable;

    protected static ?string $model = Trove::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        $tagFields = self::getTagFields();

        return $form
            ->schema([
                Wizard::make([

                    Wizard\Step::make('Details')
                        ->icon('heroicon-m-information-circle')
                        ->columns(1)
                        ->schema([
                            Forms\Components\Section::make('Title')
                                ->description('Add a useful title for the resource, this could be the title of the document, or the name of the software, etc.')
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
                                ->description('For example: What is this trove? Who is it for? Why was it made or uploaded?')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('description')->hiddenOn(['edit', 'create']),
                                    Forms\Components\MarkdownEditor::make('description_en')
                                        ->label('English')
                                        ->disableToolbarButtons(['attachFiles'])
                                        ->requiredWithoutAll('description_es, description_fr')
                                        ->validationMessages(['required_without_all' => 'Enter the description in at least one language']),
                                    Forms\Components\MarkdownEditor::make('description_es')
                                        ->label('Spanish')
                                        ->disableToolbarButtons(['attachFiles'])
                                        ->requiredWithoutAll('description_en, description_fr')
                                        ->validationMessages(['required_without_all' => 'Enter the description in at least one language']),
                                    Forms\Components\MarkdownEditor::make('description_fr')
                                        ->label('French')
                                        ->disableToolbarButtons(['attachFiles'])
                                        ->requiredWithoutAll('description_es, description_en')
                                        ->validationMessages(['required_without_all' => 'Enter the description in at least one language']),
                                ]),

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
                                ->minDate(now()->subYears(30))
                                ->maxDate(now())
                                ->required(),

                            Forms\Components\Hidden::make('uploader_id')->default(Auth::user()->id),
                        ]),

                    Wizard\Step::make('Tags')
                        ->icon('heroicon-m-tag')
                        ->schema([
                            Forms\Components\Section::make('Tags')
                                ->description('These tags help organise and filter the resources on the front-end. Except where specified, you must select from existing tags. If you believe a new tag is required, please contact Emily. You can apply as many tags as you need for each category.')
                                ->columns(2)
                                ->schema($tagFields),
                        ]),

                    Wizard\Step::make('Content')
                        ->icon('heroicon-m-link')
                        ->schema([
                            Forms\Components\Section::make('Files')
                                ->description('Multiple files can be uploaded if necessary')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('files_en')
                                        ->label('English')
                                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: ('A trove will often contain multiple files. These are files that work together, for example a questions and answers sheet, or a document translated into different languages.'))
                                        ->multiple()
                                        ->enableReordering()
                                        ->collection('content_en'),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('files_es')
                                        ->label('Spanish')
                                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: ('These are files that work together, for example a questions and answers sheet, or a document translated into different languages.'))
                                        ->multiple()
                                        ->enableReordering()
                                        ->collection('content_es'),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('files_fr')
                                        ->label('French')
                                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: ('These are files that work together, for example a questions and answers sheet, or a document translated into different languages.'))
                                        ->multiple()
                                        ->enableReordering()
                                        ->collection('content_fr'),
                                ]),


                            Forms\Components\Section::make('External Links')
                                ->description('Websites, files etc., hosted by other people')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\Repeater::make('external_links_en')
                                        ->label('English')
                                        ->schema([
                                            Forms\Components\TextInput::make('link_title'),
                                            Forms\Components\TextInput::make('link_url')
                                                ->label('Link URL'),
                                        ])
                                        ->columns(1)
                                        ->addActionLabel('Add another link'),
                                    Forms\Components\Repeater::make('external_links_es')
                                        ->label('Spanish')
                                        ->schema([
                                            Forms\Components\TextInput::make('link_title'),
                                            Forms\Components\TextInput::make('link_url')
                                                ->label('Link URL'),
                                        ])
                                        ->columns(1)
                                        ->addActionLabel('Add another link'),
                                    Forms\Components\Repeater::make('external_links_fr')
                                        ->label('French')
                                        ->schema([
                                            Forms\Components\TextInput::make('link_title'),
                                            Forms\Components\TextInput::make('link_url')
                                                ->label('Link URL'),
                                        ])
                                        ->columns(1)
                                        ->addActionLabel('Add another link'),
                                ]),

                            Forms\Components\Section::make('Youtube Videos')
                                ->description('Add the youtube id if you have added a video file that already exists on YouTube. On YouTube, when you hit "share", the id is the random-like string after https://youtu.be/')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\Repeater::make('youtube_links_en')
                                        ->label('English')
                                        ->schema([
                                            Forms\Components\TextInput::make('youtube_id')
                                                ->label('YouTube id'),
                                        ])
                                        ->addActionLabel('Add another YouTube video'),
                                    Forms\Components\Repeater::make('youtube_links_es')
                                        ->label('Spanish')
                                        ->schema([
                                            Forms\Components\TextInput::make('youtube_id')
                                                ->label('YouTube id'),
                                        ])
                                        ->addActionLabel('Add another YouTube video'),
                                    Forms\Components\Repeater::make('youtube_links_fr')
                                        ->label('French')
                                        ->schema([
                                            Forms\Components\TextInput::make('youtube_id')
                                                ->label('YouTube id'),
                                        ])
                                        ->addActionLabel('Add another YouTube video'),
                                ]),
                        ]),

                    Wizard\Step::make('Cover Image')
                        ->icon('heroicon-m-photo')
                        ->schema([
                            Forms\Components\Fieldset::make('cover_image')
                                ->label('Cover Image')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_en')
                                        ->label('English')
                                        ->collection('trove_cover_en'),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_es')
                                        ->label('Spanish')
                                        ->collection('trove_cover_es'),
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image_fr')
                                        ->label('French')
                                        ->collection('trove_cover_fr'),
                                ]),
                        ]),

                    Wizard\Step::make('Check')
                        ->icon('heroicon-m-clipboard-document-check')
                        ->schema([
                            Placeholder::make('check_info')
                                ->disableLabel()
                                ->content(new HtmlString('Checking section')),
                            Forms\Components\Checkbox::make('public')
                                ->label('Is this trove resource ready to be shared externally?'),
                        ]),
                ])
                    ->skippable(),
                // ->submitAction(new HtmlString('<button type="submit">Submit</button>'))
            ])->columns(1);
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
                Tables\Columns\TextColumn::make('tags_count')
                    ->label('# Tags')
                    ->sortable()
                    ->counts('tags'),
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
                    ->relationship('user', 'name'),
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

    private static function getTagFields(): array
    {
        return TagType::all()->map(function (TagType $tagType) {

            // TODO: add freetext option (probably a createOptionForm)
            return Forms\Components\Select::make("tags_{$tagType->slug}")
                ->relationship('tags', 'name')
                ->options($tagType->tags->pluck('name', 'id'))
                ->label($tagType->label)
                ->placeholder('Select tags')
                ->multiple()
                ->preload()
                ->loadingMessage('Loading tags...')
                ->noSearchResultsMessage('No tags match your search')
                ->getOptionLabelFromRecordUsing(fn($record, $livewire) => $record->getTranslation('name', 'en'))
                ->hintIcon(
                    icon: 'heroicon-m-question-mark-circle',
                    tooltip: fn() => $tagType->description
                );
        })
            ->toArray();


    }
}
