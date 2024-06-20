<?php

namespace App\Providers;

use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table
                ->emptyStateHeading('No data yet')
                ->striped()
                ->defaultPaginationPageOption(10)
                ->paginated([10, 25, 50, 100])
                ->extremePaginationLinks()
                ->defaultSort('created_at', 'desc');
        });
        Model::unguard();

        \BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch::configureUsing(
            function (\BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch $switch) 
            {
                $switch->locales(['en','fr','vi'])
                    ->flags([
                        'fr' => asset('/images/flags/france.png'),
                        'en' => asset('/images/flags/united-kingdom.png'),
                        'vi' => asset('/images/flags/vietnam.png'),
                    ]); // also accepts a closure
            }
        );
    }
}
