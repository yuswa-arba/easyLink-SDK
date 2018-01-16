<?php

namespace App\Providers;

use App\Model\tb_scanlog;
use App\Observer\RealtimeObserver;
use App\Service\realTimeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        tb_scanlog::observe(RealtimeObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
