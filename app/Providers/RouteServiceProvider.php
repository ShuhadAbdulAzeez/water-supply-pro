<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Limit;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BillController;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // Add authentication middleware to all routes except login, register, and password reset
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');

            // Add your protected routes here
            Route::resource('customers', CustomerController::class);
            Route::resource('staff', StaffController::class);
            Route::resource('trucks', TruckController::class);
            Route::resource('inventory', InventoryController::class);
            Route::resource('bills', BillController::class);
        });
    }
} 