<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TagType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Split;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\TagTypeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagTypeResource\RelationManagers;

class TagTypeResource extends Resource
{
    use Translatable;
    
    protected static ?string $model = TagType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('label_field')
                                ->label('Label')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('label')->hiddenOn(['edit', 'create']),
                                    Forms\Components\TextInput::make('label_en')
                                                    ->label('English')
                                                    ->requiredWithoutAll('label_es, label_fr')
                                                    ->validationMessages(['required_without_all' => 'Enter the label in at least one language']),
                                    Forms\Components\TextInput::make('label_es')
                                                    ->label('Spanish')
                                                    ->requiredWithoutAll('label_en, label_fr')
                                                    ->validationMessages(['required_without_all' => 'Enter the label in at least one language']),
                                    Forms\Components\TextInput::make('label_fr')
                                                    ->label('French')
                                                    ->requiredWithoutAll('label_es, label_en')
                                                    ->validationMessages(['required_without_all' => 'Enter the label in at least one language']),
                                ]),

                Forms\Components\Fieldset::make('description_field')
                                ->label('Description')
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
                
                Forms\Components\Section::make('')
                                ->schema([Forms\Components\Checkbox::make('freetext')
                                                ->label('Does this bucket accept new tag entries during Trove upload?')
                                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Most buckets should not have this enabled, to prevent accidental duplication / mistyping during Trove upload.'),
                                            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label'),                                
                Tables\Columns\TextColumn::make('description')->wrap(),
                Tables\Columns\IconColumn::make('freetext')
                                ->boolean()
                                ->trueColor('success')
                                ->falseColor('warning'),
                // Tables\Columns\TextColumn::make('tags_count')
                //                 ->counts('tags')
                //                 ->label('# Tags')
                //                 ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTagTypes::route('/'),
            'create' => Pages\CreateTagType::route('/create'),
            'edit' => Pages\EditTagType::route('/{record}/edit'),
        ];
    }    
}
