<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TroveTypeResource\Pages;
use App\Filament\Resources\TroveTypeResource\RelationManagers;
use Filament\Resources\Concerns\Translatable;
use App\Models\TroveType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TroveTypeResource extends Resource
{
    use Translatable;
    
    protected static ?string $model = TroveType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static ?string $navigationLabel = 'Trove Types';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('label')->required(),
                    ]),
                    Forms\Components\Section::make([
                        Forms\Components\Select::make('label_language')
                                            ->label('Language')
                                            ->options(['en' =>'English', 'es' => 'Spanish', 'fr' => 'French'])
                                            ->required(fn(string $operation) => $operation == 'create')
                                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Select the language you are using to create this trove type. After the trove type has been created, translations for the other languages can be added at any time while in \'Edit Trove Type\' mode.'),
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
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('troves_count')
                                ->counts('troves')
                                ->label('# Troves')
                                ->sortable(),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListTroveTypes::route('/'),
            'create' => Pages\CreateTroveType::route('/create'),
            'edit' => Pages\EditTroveType::route('/{record}/edit'),
        ];
    }    
}
