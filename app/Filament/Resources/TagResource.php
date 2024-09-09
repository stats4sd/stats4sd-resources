<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use App\Models\TagType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagResource\RelationManagers;
use Filament\Resources\Concerns\Translatable;

class TagResource extends Resource
{
    use Translatable;

    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('name_field')
                    ->label('Name')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('name')->hiddenOn(['edit', 'create']),
                        Forms\Components\TextInput::make('name_en')
                            ->label('English')
                            ->requiredWithoutAll('name_es, name_fr')
                            ->validationMessages(['required_without_all' => 'Enter the name in at least one language']),
                        Forms\Components\TextInput::make('name_es')
                            ->label('Spanish')
                            ->requiredWithoutAll('name_en, name_fr')
                            ->validationMessages(['required_without_all' => 'Enter the name in at least one language']),
                        Forms\Components\TextInput::make('name_fr')
                            ->label('French')
                            ->requiredWithoutAll('name_es, name_en')
                            ->validationMessages(['required_without_all' => 'Enter the name in at least one language']),
                    ]),

                Forms\Components\Select::make('type_id')
                    ->relationship('tagType', 'name')
                    ->required()
                    ->getOptionLabelFromRecordUsing(fn($record, $livewire) => $record->getTranslation('label', 'en')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('tagType.label'),
                Tables\Columns\TextColumn::make('troves_count')
                    ->label('# of troves')
                    ->counts('troves')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tagType')
                    ->relationship('tagType', 'label')
                    ->getOptionLabelFromRecordUsing(fn($record, $livewire) => $record->getTranslation('label', 'en')),
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
