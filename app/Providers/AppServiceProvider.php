<?php

namespace App\Providers;

use Botble\Base\Facades\DashboardMenu;
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
        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()->registerItem([
                'id' => 'cms-app-line-feature',
                'priority' => 125,
                'name' => 'LINE Feature',
                'icon' => 'ti ti-brand-line',
                'route' => 'line-feature.index',
                'permissions' => false,
            ]);

            DashboardMenu::make()->registerItem([
                'id' => 'cms-app-seo-machine',
                'priority' => 126,
                'name' => 'SEO Machine',
                'icon' => 'ti ti-search',
                'route' => 'seo-machine.index',
                'permissions' => false,
            ]);
        });
    }
}
