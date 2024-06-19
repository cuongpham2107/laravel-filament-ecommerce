<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\ProductResource\Pages;
use App\Models\Shop\Attribute;
use App\Models\Shop\Option;
use App\Models\Shop\Product;
use App\Models\Shop\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $modelLabel = 'Products';


    protected static ?string $navigationGroup = "Shop";

    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('tas')->tabs([
                    Tabs\Tab::make('Product info')->schema([
                        Group::make()->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Tên sản phẩm')
                                        ->rules(['min:3','max:50'])
                                        ->live(onBlur: true)
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
                                    MarkdownEditor::make('content')
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
                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->helperText('Enable or disable product featured status')
                                    ->default(true)
                                    ->onIcon('heroicon-m-check')
                                    ->offIcon('heroicon-m-x-mark'),
                                DatePicker::make('created_at')
                                    ->label('Date created')
                                    ->default(now())
                                    ->columnSpanFull(),
                            ])->columns(2),
                            Section::make('Images')->schema([
                                FileUpload::make('thumbnail')
                                    ->directory('form-attachments')
                                    ->preserveFilenames()
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorMode(2)
                                    ->imageEditorAspectRatios([
                                        null,
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ]),
                                FileUpload::make('images')
                                    ->multiple()
                                    ->reorderable()
                                    ->appendFiles()
                                    ->previewable(false)
                            ])->collapsible(),
                            Section::make('Association')->schema([
                                Select::make('brand_id')
                                    ->relationship('brand','name')
                                    ->searchable()
                                    ->required(),
                                Select::make('categories')
                                    ->relationship()
                                    ->options(ProductCategory::query()->pluck('name','id'))
                                    ->multiple()
                                    ->reactive()
                                    ->required(),
                                    
                            ]),
                            Section::make('See more')->schema([
                                TagsInput::make('tags')
                            ])
                        ])->columnSpan(1),
    
                    ])->columns(3),
                    Tabs\Tab::make('Product Aariants')->schema([
                        Repeater::make('variants')
                            ->relationship('variants')
                            ->schema([
                                Select::make('attributes')
                                    ->relationship()
                                    ->options(Attribute::query()->pluck('value','id'))
                                    ->multiple()
                                    ->createOptionForm([
                                        Section::make()->schema([
                                            Select::make('type')
                                                ->options(Option::query()->pluck('name','id'))
                                                ->required()
                                                ->columnSpan(2),
                                            TextInput::make('value')
                                                ->required()
                                                ->columnSpan(2),
                                            Toggle::make('is_visible')
                                                ->default(true)
                                                ->label('Visible')
                                                ->onIcon('heroicon-m-check')
                                                ->offIcon('heroicon-m-x-mark')
                                                ->inline(false)
                                        ])->columns(5)
                                    ])
                                    ->columnSpan(3),
                                TextInput::make('sku')->columnSpan(1),
                                TextInput::make('stock')->numeric()->columnSpan(1),
                                TextInput::make('price')->numeric()->columnSpan(1),
                            ])
                            ->cloneable()
                         ->columns(6)
                    ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('category.name')
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('brand.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tags')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_visible')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Published on')
                    ->date()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter::make("Published Product")->query(
                //     function (Builder $query): Builder {
                //         return $query->where('published', true);
                //     }
                // ),
                // SelectFilter::make('category_id')
                //     ->label('Category')
                //     ->options(Category::all()->pluck('name','id'))

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

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
