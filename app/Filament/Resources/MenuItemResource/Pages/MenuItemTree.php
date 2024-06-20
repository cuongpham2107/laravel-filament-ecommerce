<?php

namespace App\Filament\Resources\MenuItemResource\Pages;

use App\Filament\Resources\MenuItemResource;
use Filament\Pages\Actions\CreateAction;
use SolutionForest\FilamentTree\Actions;
use SolutionForest\FilamentTree\Concern;
use SolutionForest\FilamentTree\Resources\Pages\TreePage as BasePage;
use SolutionForest\FilamentTree\Support\Utils;

class MenuItemTree extends BasePage
{
    protected static string $resource = MenuItemResource::class;

    protected static int $maxDepth = 2;

    protected function getActions(): array
    {
        return [
            $this->getCreateAction(),
            // SAMPLE CODE, CAN DELETE
            //\Filament\Pages\Actions\Action::make('sampleAction'),
            Actions\ViewAction::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function hasDeleteAction(): bool
    {
        return false;
    }

    protected function hasEditAction(): bool
    {
        return true;
    }

    protected function hasViewAction(): bool
    {
        return false;
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        return 'heroicon-o-cake';
    }
}