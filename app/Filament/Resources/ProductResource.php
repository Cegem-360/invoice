<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nev')->label(__('Név'))
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(false),
                TextInput::make('ean')
                    ->label('EAN')
                    ->required(false),
                TextInput::make('price')
                    ->label('Netto ár')
                    ->required(false)
                    ->numeric()
                    ->default(0),
                TextInput::make('price_kivitelezok')
                    ->label('Kivitelezői ár')
                    ->required(false)
                    ->numeric()
                    ->default(0),
                TextInput::make('price_kp_elore_harminc')
                    ->label('Készpénz előre 30 %')
                    ->required(false)
                    ->numeric()
                    ->default(0),
                TextInput::make('price_kp_elore_huszonot')
                    ->label('Készpénz előre 25 %')
                    ->required(false),
                TextInput::make('storage')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nev')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ean')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_kivitelezok')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_kp_elore_harminc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_kp_elore_huszonot')
                    ->searchable(),
                Tables\Columns\TextColumn::make('storage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
