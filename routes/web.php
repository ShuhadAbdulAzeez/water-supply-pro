<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Enable route caching in production
if (app()->environment('production')) {
    URL::forceScheme('https');
}

Route::get('/', [DashboardController::class, 'index']);

// Basic Routes without auth
Route::resource('customers', CustomerController::class);
Route::resource('inventory', InventoryController::class);
Route::resource('staff', StaffController::class);
Route::resource('trucks', TruckController::class);


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Routes
    Route::resource('customers', CustomerController::class);

    // Bills Routes
    Route::resource('bills', BillController::class);
    Route::post('/bills/{bill}/pay', [BillController::class, 'pay'])->name('bills.pay');
    Route::post('/bills/{bill}/unpay', [BillController::class, 'unpay'])->name('bills.unpay');
    Route::get('/bills/search', [BillController::class, 'search'])->name('bills.search');
    Route::get('/bills/filter', [BillController::class, 'filter'])->name('bills.filter');
    Route::get('/bills/export', [BillController::class, 'export'])->name('bills.export');
    Route::post('/bills/import', [BillController::class, 'import'])->name('bills.import');
    Route::get('/bills/{bill}/print', [BillController::class, 'print'])->name('bills.print');
    Route::get('/bills/{bill}/download', [BillController::class, 'download'])->name('bills.download');
    Route::post('/bills/{bill}/email', [BillController::class, 'email'])->name('bills.email');
    Route::get('/bills/{bill}/pdf', [BillController::class, 'pdf'])->name('bills.pdf');
    Route::get('/bills/print-all', [BillController::class, 'printAll'])->name('bills.print_all');
    Route::get('/bills/download-all', [BillController::class, 'downloadAll'])->name('bills.download_all');

    // Bottles Routes
    Route::resource('bottles', BottleController::class);
    Route::post('/bottles/{bottle}/mark-damaged', [BottleController::class, 'markDamaged'])->name('bottles.mark-damaged');
    Route::post('/bottles/{bottle}/mark-empty', [BottleController::class, 'markEmpty'])->name('bottles.mark-empty');
    Route::post('/bottles/{bottle}/mark-filled', [BottleController::class, 'markFilled'])->name('bottles.mark-filled');
    Route::get('/bottles/{bottle}/print', [BottleController::class, 'print'])->name('bottles.print');
    Route::get('/bottles/{bottle}/download', [BottleController::class, 'download'])->name('bottles.download');
    Route::get('/bottles/{bottle}/pdf', [BottleController::class, 'pdf'])->name('bottles.pdf');
    Route::get('/bottles/{bottle}/email', [BottleController::class, 'email'])->name('bottles.email');
    Route::get('/bottles/print-all', [BottleController::class, 'printAll'])->name('bottles.print_all');
    Route::get('/bottles/download-all', [BottleController::class, 'downloadAll'])->name('bottles.download_all');
    Route::get('/bottles/search', [BottleController::class, 'search'])->name('bottles.search');
    Route::get('/bottles/filter', [BottleController::class, 'filter'])->name('bottles.filter');
    Route::get('/bottles/export', [BottleController::class, 'export'])->name('bottles.export');
    Route::post('/bottles/import', [BottleController::class, 'import'])->name('bottles.import');
    Route::get('/bottles/{bottle}/history', [BottleController::class, 'history'])->name('bottles.history');

    // Inventory Routes - CUSTOM ROUTES FIRST!
    Route::get('/inventory/daily-report', [InventoryController::class, 'dailyReport'])->name('inventory.daily-report');
    Route::get('/inventory/search', [InventoryController::class, 'search'])->name('inventory.search');
    Route::get('/inventory/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
    Route::get('/inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
    Route::get('/inventory/print-all', [InventoryController::class, 'printAll'])->name('inventory.print_all');
    Route::get('/inventory/download-all', [InventoryController::class, 'downloadAll'])->name('inventory.download_all');
    Route::post('/inventory/import', [InventoryController::class, 'import'])->name('inventory.import');
    
    // Then the resource route
    Route::resource('inventory', InventoryController::class);
    
    // Then individual inventory item routes
    Route::get('/inventory/{inventory}/print', [InventoryController::class, 'print'])->name('inventory.print');
    Route::get('/inventory/{inventory}/download', [InventoryController::class, 'download'])->name('inventory.download');
    Route::get('/inventory/{inventory}/pdf', [InventoryController::class, 'pdf'])->name('inventory.pdf');
    Route::get('/inventory/{inventory}/email', [InventoryController::class, 'email'])->name('inventory.email');
    Route::get('/inventory/{inventory}/history', [InventoryController::class, 'history'])->name('inventory.history');

    // Staff Routes
    Route::resource('staff', StaffController::class);

    // Trucks Routes
    Route::resource('trucks', TruckController::class);
    Route::get('/trucks/{truck}/print', [TruckController::class, 'print'])->name('trucks.print');
    Route::get('/trucks/{truck}/download', [TruckController::class, 'download'])->name('trucks.download');
    Route::get('/trucks/{truck}/pdf', [TruckController::class, 'pdf'])->name('trucks.pdf');
});

// Authentication Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

require __DIR__ . '/auth.php';

Route::get('/phpinfo', function () {
    phpinfo();
});

