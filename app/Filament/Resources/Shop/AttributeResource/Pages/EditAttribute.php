<?php

namespace App\Filament\Resources\Shop\AttributeResource\Pages;

use App\Filament\Resources\Shop\AttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttribute extends EditRecord
{
    protected static string $resource = AttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
