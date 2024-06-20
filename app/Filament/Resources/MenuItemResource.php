<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static int $maxDepth = 2;
    protected ?string $treeTitle = 'MenuItem';
    protected bool $enableTreeTitle = true;
    protected static ?string $navigationGroup = "Settings";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Group::make()->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->live(onBlur: true)
                            // ->unique()
                            ->required(),
                        TextInput::make('url')
                            ->suffixIcon('heroicon-m-globe-alt'),
                        Select::make('target')
                            ->options([
                                '_blank' => 'Blank',
                                '_self' => 'Self'
                                ])
                                ->default('_self'),
                        TextInput::make('icons'),
                        ColorPicker::make('color'),
                        TextInput::make('order_id')
                            ->numeric(),
                    ])->columns(2),

            ])->columnSpan(2),
            Group::make()->schema([
                
                Section::make('Association')->schema([
                    Select::make('parent_id')
                        ->relationship('parent','name')
                        ->reactive(),
                       Select::make('menu_id')
                        ->relationship('menu','name')
                        ->reactive(),
                                
                ])
            ]),
           
        ])->columns(3);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('url'),
                TextColumn::make('target'),
                TextColumn::make('icons'),
                ColorColumn::make('color'),
                TextColumn::make('order_id'),
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
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
        ];
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
            'tree-list' => Pages\MenuItemTree::route('/tree-list'),
        ];
    }
}
