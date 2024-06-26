<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\AdminLte;

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
        View::composer('*', function ($view) {
            $adminlte = app(AdminLte::class);
            $view->with('adminlte', $adminlte);
        });

        Carbon::setLocale(config('app.locale'));
        Carbon::macro('now', function() {
            return Carbon::createFromTimestamp(time(), config('app.timezone'));
        });
    }
}
