<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;

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
        URL::forceRootUrl(Config::get('app.url'));
        if (str_contains(Config::get('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        Inertia::share([
            'laravelVersion' => function () {
                return Application::VERSION;
            },
            'projectVersion' => function () {
                return '0.0.1';
            },
            'venues' => function () {
                return [
                    ['id' => 1, 'name' => 'La Cucina', 'color' => 'green'],
                    ['id' => 2, 'name' => 'Scante', 'color' => 'grey'],
                    ['id' => 3, 'name' => 'Enoteca', 'color' => 'red'],
                ];
            },
        ]);
    }
}
