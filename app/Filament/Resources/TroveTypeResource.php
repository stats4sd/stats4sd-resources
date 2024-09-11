<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TroveTypeResource\Pages;
use App\Filament\Resources\TroveTypeResource\RelationManagers;
use App\Filament\Translatable\Form\TranslatableComboField;
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
                TranslatableComboField::make('label')
                    ->label(__('Trove Type'))
                    ->description('Enter the name of the trove type. E.g. "video", "presentation", "ODK Form Template", "R Project"')
                    ->icon('heroicon-s-tag')
                    ->iconColor('primary')
                    ->extraAttributes(['style' => 'background-color: #e6e6e6;'])
                    ->columns(3)
                    ->childField(Forms\Components\TextInput::class),
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
                Tables\Actions\EditAction::make()
                    ->modalHeading(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading(''),
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
        ];
    }
}
