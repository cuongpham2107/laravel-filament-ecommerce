<?php

namespace App\Filament\Resources\Shop\VariantResource\Pages;

use App\Filament\Resources\Shop\VariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVariants extends ListRecords
{
    protected static string $resource = VariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
