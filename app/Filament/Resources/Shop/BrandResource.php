<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\BrandResource\Pages;
use App\Filament\Resources\Shop\BrandResource\RelationManagers;
use App\Models\Shop\ProductBrand;
use App\Models\Brand;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = ProductBrand::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationGroup = "Shop";

    protected static ?string $navigationLabel= "Brand";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                        Section::make([
                            TextInput::make('name')
                                ->required()
                                ->live(onBlur:true)
                                ->unique()
                                ->afterStateUpdated(function (?string $operation, ?string $state, Forms\Set $set){
                                    if($operation !== 'create'){
                                        return;
                                    }
                                    $set('slug',Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->unique()
                                ->required(),
                            MarkdownEditor::make('description')
                                ->columnSpanFull()
                        ])->columns(2),
                        
                    ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('See info')->schema([
                        
                        Toggle::make('is_visible')
                            ->label('Visible')
                            ->helperText('Enable or disable product visibilty')
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->directory('form-attachments')
                            ->preserveFilenames()
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper(),
                       
                    ]),
                ])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('name'),
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
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()
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
            'index' => Pages\ListBrands::route('/'),
            // 'create' => Pages\CreateBrand::route('/create'),
            // 'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
