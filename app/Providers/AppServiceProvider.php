<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
    public function boot()
    {
        // Set higher memory limit
        ini_set('memory_limit', '1G');
        
        // Disable query logging
        DB::disableQueryLog();
        
        // Enable view caching
        config(['view.cache' => true]);
        
        // Optimize database
        config(['database.connections.mysql.strict' => false]);
    }
}
