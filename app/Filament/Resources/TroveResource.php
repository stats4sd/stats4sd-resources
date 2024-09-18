<?php

namespace App\Filament\Resources;

use App\Filament\Translatable\Form\TranslatableComboField;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Tables;
use App\Models\Trove;
use App\Models\TagType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Guava\FilamentDrafts\Admin\Resources\Concerns\Draftable;
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

class TroveResource extends Resource
{
    use Translatable;
    use Draftable;

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
                            TranslatableComboField::make('title')
                                ->icon('heroicon-o-exclamation-circle')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->columns(3)
                                ->heading(__('Title'))
                                ->hint(__('Add a useful title for the resource, this could be the title of the document, or the name of the software, etc.'))
                                ->childField(
                                    TextInput::class,
                                )
                                ->required(),
                            TranslatableComboField::make('description')
                                ->icon('heroicon-o-document-text')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->columns(1)
                                ->heading(__('Description'))
                                ->hint(__('For example: What is this trove? Who is it for? Why was it made or uploaded?'))
                                ->childField(
                                    Forms\Components\MarkdownEditor::class,
                                )
                                ->required(),

                            Forms\Components\Section::make('Metadata')
                                ->icon('heroicon-o-document-chart-bar')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->description(__('Key metadata for filters and search'))
                                ->schema([

                                    Forms\Components\Select::make('trove_type_id')
                                        ->placeholder('Select the resource type')
                                        ->relationship('troveType', 'label')
                                        ->required()
                                        ->default(1) // TODO: REMOVE THIS
                                        ->getOptionLabelFromRecordUsing(fn($record, $livewire) => $record->getTranslation('label', 'en')),

                                    Forms\Components\Select::make('source')
                                        ->placeholder('Select the origin of the resource')
                                        ->options([0 => 'Internal', 1 => 'External'])
                                        ->default(0) // TODO: REMOVE THIS
                                        ->required(),

                                    Forms\Components\DatePicker::make('creation_date')
                                        ->label('When was the resource created?')
                                        ->helperText('To the nearest month (approximately is fine). This is mainly to highlight to users when a resource might be a bit out of date.')
                                        ->minDate(now()->subYears(30))
                                        ->maxDate(now())
                                        ->required()
                                        ->default('2020-01-01'), // TODO: REMOVE THIS

                                    Forms\Components\Hidden::make('uploader_id')->default(Auth::user()->id),
                                ]),
                        ]),

                    Wizard\Step::make('Tags')
                        ->icon('heroicon-m-tag')
                        ->schema([
                            Forms\Components\Section::make('Tags')
                                ->icon('heroicon-m-tag')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->description('These tags help organise and filter the resources on the front-end. Except where specified, you must select from existing tags. If you believe a new tag is required, please contact Emily. You can apply as many tags as you need for each category.')
                                ->columns(2)
                                ->schema($tagFields),
                        ]),

                    Wizard\Step::make('Content')
                        ->icon('heroicon-m-link')
                        ->schema([
                            TranslatableComboField::make('files')
                                ->icon('heroicon-o-document')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->heading(__('Files'))
                                ->hint('Multiple files can be uploaded if necessary')
                                ->columns(3)
                                ->hintIcon(
                                    icon: 'heroicon-m-question-mark-circle',
                                    tooltip: __('A trove will often contain multiple files. These are files that work together, for example a questions and answers sheet, or a document translated into different languages.'))
                                ->childField(
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('files')
                                        ->multiple()
                                        ->reorderable()
                                ),

                            TranslatableComboField::make('external_links')
                                ->icon('heroicon-o-link')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->heading(__('External Links'))
                                ->hint(__('Websites, files etc., hosted by other people'))
                                ->childField(
                                    Repeater::make('-')
                                        ->label('-')
                                        ->schema([
                                            TextInput::make('link_title'),
                                            TextInput::make('link_url')
                                                ->label('Link URL'),
                                        ])
                                        ->columns(1)
                                        ->addActionLabel('Add another link')
                                ),

                            TranslatableComboField::make('youtube_links')
                                ->icon('heroicon-o-video-camera')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->heading(__('YouTube Videos'))
                                ->hint('Add the youtube id if you have added a video file that already exists on YouTube. On YouTube, when you hit "share", the id is the random-like string after https://youtu.be/')
                                ->columns(3)
                                ->childField(
                                    Forms\Components\Repeater::make('youtube_links')
                                        ->schema([
                                            Forms\Components\TextInput::make('youtube_id')
                                                ->label('YouTube ID'),
                                        ])
                                        ->addActionLabel('Add another YouTube video'),
                                ),
                        ]),

                    Wizard\Step::make('Cover Image')
                        ->icon('heroicon-m-photo')
                        ->schema([
                            TranslatableComboField::make('cover_image')
                                ->icon('heroicon-o-photo')
                                ->iconColor('primary')
                                ->extraAttributes(['style' => 'background-color: #E6E6E6;'])
                                ->heading(__('Cover Image'))
                                ->hint(__('Add a cover image for the resource. This will be displayed on the front-end.'))
                                ->columns(3)
                                ->childField(
                                    Forms\Components\SpatieMediaLibraryFileUpload::make('cover_image')
                                        ->collection('trove_cover')
                                ),
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
