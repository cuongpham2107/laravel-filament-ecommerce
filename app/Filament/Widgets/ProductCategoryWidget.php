<?php

namespace App\Filament\Widgets;

use App\Models\Shop\ProductCategory;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class ProductCategoryWidget extends BaseWidget
{
    protected static string $model = ProductCategory::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'ProductCategoryWidget';

    protected bool $enableTreeTitle = true;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
        ];
    }

    // INFOLIST, CAN DELETE
    public function getViewFormSchema(): array {
        return [
            //
        ];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        return null;
    }
    
    public function getNodeCollapsedState(?\Illuminate\Database\Eloquent\Model $record = null): bool
    {
        // All tree nodes will be collapsed by default.
        return true;
    }
    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE 
    protected function getTreeActions(): array
    {
        return [
            // Action::make('helloWorld')
            //     ->action(function () {
            //         Notification::make()->success()->title('Hello World')->send();
            //     }),
            ViewAction::make(),
            EditAction::make(),
            // ActionGroup::make([
                
            //     ViewAction::make(),
            //     EditAction::make(),
            // ]),
            DeleteAction::make(),
        ];
    }
    // OR OVERRIDE FOLLOWING METHODS
    protected function hasDeleteAction(): bool
    {
       return true;
    }
    protected function hasEditAction(): bool
    {
       return true;
    }
    protected function hasViewAction(): bool
    {
       return true;
    }
}