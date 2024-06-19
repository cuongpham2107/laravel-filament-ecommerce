<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\CategoryResource\Pages;
use App\Filament\Resources\Shop\CategoryResource\RelationManagers;
use App\Models\Shop\ProductCategory;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = "Shop";

    protected static ?string $navigationLabel= "Category";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
                Group::make()->schema([
                    Section::make()
                        ->schema([
                            TextInput::make('name')
                                ->live(onBlur: true)
                                ->unique()
                                ->required()
                                ->afterStateUpdated(
                                    function (
                                        ?string $operation,
                                        ?string $state,
                                        Forms\Set $set
                                    ) {
                                        if ($operation === 'edit') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    }
                                ),
                               
                            TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->unique(ignoreRecord: true)
                                ->required(),
                            MarkdownEditor::make('description')
                                ->columnSpanFull(),
                        ])->columns(2),
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Status')->schema([
                        Toggle::make('is_visible')
                            ->label('Visible')
                            ->helperText('Enable or disable product visibilty')
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                        
                    ]),
                    Section::make('Association')->schema([
                        Select::make('parent_id')
                            ->relationship('parent','name')
                            ->multiple()
                            ->searchable('name')
                            ->reactive()
                    ])
                ]),
               
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug'),
                TextColumn::make('parent.name'),
                IconColumn::make('is_visible')
                    ->label('Visibilty')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListCategories::route('/'),
            // 'create' => Pages\CreateCategory::route('/create'),
            // 'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
