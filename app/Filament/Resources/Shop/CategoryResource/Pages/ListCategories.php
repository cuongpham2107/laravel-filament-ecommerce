<?php

namespace App\Filament\Resources\Shop\CategoryResource\Pages;

use App\Filament\Resources\Shop\CategoryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use AymanAlhattami\FilamentContextMenu\Traits\PageHasContextMenu;
use App\Filament\Resources\Shop\CategoryResource\Pages\CreateCategory;
use App\Filament\Widgets\ProductCategoryWidget;

class ListCategories extends ListRecords
{
    use PageHasContextMenu;
    
    protected static string $resource = CategoryResource::class;

    // public function getContextMenuActions(): array
    // {
    //     return [
    //         Action::make('Create user')
    //             ->url(CreateCategory::getUrl())
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            ProductCategoryWidget::class
        ];
    }


   
}
