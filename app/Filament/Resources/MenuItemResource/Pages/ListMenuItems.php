<?php

namespace App\Filament\Resources\MenuItemResource\Pages;

use App\Filament\Resources\MenuItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\MenuItemWidget;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemResource::class;
   
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MenuItemWidget::class
        ];
    }
}
