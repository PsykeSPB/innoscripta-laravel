<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CurrencyExchangeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CurrencyExchangeService::class, function($app) {
            return new CurrencyExchangeService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
