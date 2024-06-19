<?php

namespace App\Filament\Resources\Shop\OptionResource\Pages;

use App\Filament\Resources\Shop\OptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOption extends EditRecord
{
    protected static string $resource = OptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
