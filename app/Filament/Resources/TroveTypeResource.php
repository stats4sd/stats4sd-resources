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
