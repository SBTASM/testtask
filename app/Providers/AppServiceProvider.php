<?php

namespace App\Providers;

use App\Contracts\Export;
use App\Contracts\Import;
use App\Services\CSV;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Import::class, CSV::class);
        $this->app->singleton(Export::class, CSV::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
