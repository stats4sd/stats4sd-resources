<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagTypeResource\Pages;
use App\Filament\Resources\TagTypeResource\RelationManagers;
use App\Models\TagType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;

class TagTypeResource extends Resource
{
    use Translatable;
    
    protected static ?string $model = TagType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                                    ->label('Type Name')
                                    ->required(),
                Forms\Components\TextInput::make('description')
                                    ->helperText('Text that appears as a hint in the add / edit Troves form')
                                    ->required(),
                Forms\Components\Checkbox::make('freetext')
                                    ->label('Does this bucket accept new tag entries during Trove upload?')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Most buckets should not have this enabled, to prevent accidental duplication / mistyping during Trove upload.'),
            ])->columns(1);
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
