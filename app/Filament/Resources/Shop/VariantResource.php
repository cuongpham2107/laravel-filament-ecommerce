<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\VariantResource\Pages;
use App\Filament\Resources\Shop\VariantResource\RelationManagers;
use App\Models\Shop\Attribute;
use App\Models\Shop\Variant;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantResource extends Resource
{
    protected static ?string $model = Variant::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = "Shop";

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('product_id')
                        ->relationship('product','name')
                        ->columnSpan(2),
                    Select::make('attributes')
                        ->relationship()
                        ->options(Attribute::query()->pluck('value','id'))
                        ->multiple()
                        ->columnSpan(2),
                    TextInput::make('sku')
                        ->columnSpan(1),
                    TextInput::make('stock')->numeric()
                        ->columnSpan(1),
                    TextInput::make('price')->numeric()
                        ->columnSpan(1),
                ])->columns(7)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku'),
                TextColumn::make('stock'),
                TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListVariants::route('/'),
            // 'create' => Pages\CreateVariant::route('/create'),
            // 'edit' => Pages\EditVariant::route('/{record}/edit'),
        ];
    }
}
