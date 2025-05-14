<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

// Route [customers.create] not defined.

Route::get('/customers/create', function () {
    return view('customers.create');
})->name('customers.create');
// Route [customers.store] not defined.
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
// Route [customers.show] not defined.
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
// Route [customers.edit] not defined.
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
// Route [customers.update] not defined.
Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
// Route [customers.destroy] not defined.
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
});

// Route [bills.create] not defined.

Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
// Route [bills.store] not defined.
Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
// Route [bills.show] not defined.
Route::get('/bills/{bill}', [BillController::class, 'show'])->name('bills.show');
// Route [bills.edit] not defined.
Route::get('/bills/{bill}/edit', [BillController::class, 'edit'])->name('bills.edit');
// Route [bills.update] not defined.
Route::patch('/bills/{bill}', [BillController::class, 'update'])->name('bills.update');
Route::put('/bills/{bill}', [BillController::class, 'update'])->name('bills.update');
// Route [bills.destroy] not defined.
Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');
// Route [bills.pay] not defined.
Route::post('/bills/{bill}/pay', [BillController::class, 'pay'])->name('bills.pay');
// Route [bills.unpay] not defined.
Route::post('/bills/{bill}/unpay', [BillController::class, 'unpay'])->name('bills.unpay');
// Route [bills.search] not defined.
Route::get('/bills/search', [BillController::class, 'search'])->name('bills.search');
// Route [bills.filter] not defined.
Route::get('/bills/filter', [BillController::class, 'filter'])->name('bills.filter');
// Route [bills.export] not defined.
Route::get('/bills/export', [BillController::class, 'export'])->name('bills.export');
// Route [bills.import] not defined.
Route::post('/bills/import', [BillController::class, 'import'])->name('bills.import');
// Route [bills.print] not defined.
Route::get('/bills/{bill}/print', [BillController::class, 'print'])->name('bills.print');
// Route [bills.download] not defined.
Route::get('/bills/{bill}/download', [BillController::class, 'download'])->name('bills.download');
// Route [bills.email] not defined.
Route::post('/bills/{bill}/email', [BillController::class, 'email'])->name('bills.email');
// Route [bills.pdf] not defined.
Route::get('/bills/{bill}/pdf', [BillController::class, 'pdf'])->name('bills.pdf');
// Route [bills.print_all] not defined.
Route::get('/bills/print_all', [BillController::class, 'print_all'])->name('bills.print_all');
// Route [bills.download_all] not defined.
Route::get('/bills/download_all', [BillController::class, 'download_all'])->name('bills.download_all');


Route::middleware('auth')->group(function () {
    Route::resource('bottles', BottleController::class);
});
Route::get('/bottles/create', [BottleController::class, 'create'])->name('bottles.create');
Route::post('/bottles', [BottleController::class, 'store'])->name('bottles.store');
Route::get('/bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');
Route::get('/bottles/{bottle}/edit', [BottleController::class, 'edit'])->name('bottles.edit');
Route::patch('/bottles/{bottle}', [BottleController::class, 'update'])->name('bottles.update');
Route::delete('/bottles/{bottle}', [BottleController::class, 'destroy'])->name('bottles.destroy');
Route::get('/bottles/{bottle}/print', [BottleController::class, 'print'])->name('bottles.print');
Route::get('/bottles/{bottle}/download', [BottleController::class, 'download'])->name('bottles.download');
Route::get('/bottles/{bottle}/pdf', [BottleController::class, 'pdf'])->name('bottles.pdf');
Route::get('/bottles/{bottle}/email', [BottleController::class, 'email'])->name('bottles.email');
Route::get('/bottles/print_all', [BottleController::class, 'print_all'])->name('bottles.print_all');
Route::get('/bottles/download_all', [BottleController::class, 'download_all'])->name('bottles.download_all');
Route::get('/bottles/search', [BottleController::class, 'search'])->name('bottles.search');
Route::get('/bottles/filter', [BottleController::class, 'filter'])->name('bottles.filter');
Route::get('/bottles/export', [BottleController::class, 'export'])->name('bottles.export');
Route::post('/bottles/import', [BottleController::class, 'import'])->name('bottles.import');
Route::get('/bottles/{bottle}/history', [BottleController::class, 'history'])->name('bottles.history');
Route::post('/bottles/{bottle}/mark-damaged', [BottleController::class, 'markDamaged'])->name('bottles.mark-damaged');
Route::post('/bottles/{bottle}/mark-empty', [BottleController::class, 'markEmpty'])->name('bottles.mark-empty');
Route::post('/bottles/{bottle}/mark-filled', [BottleController::class, 'markFilled'])->name('bottles.mark-filled');

Route::middleware('auth')->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
});

Route::get('/inventory/create', function () {
    return view('inventory.create');
})->name('inventory.create');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::patch('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
Route::get('/inventory/{inventory}/print', [InventoryController::class, 'print'])->name('inventory.print');
Route::get('/inventory/{inventory}/download', [InventoryController::class, 'download'])->name('inventory.download');
Route::get('/inventory/{inventory}/pdf', [InventoryController::class, 'pdf'])->name('inventory.pdf');
Route::get('/inventory/{inventory}/email', [InventoryController::class, 'email'])->name('inventory.email');
Route::get('/inventory/print_all', [InventoryController::class, 'print_all'])->name('inventory.print_all');
Route::get('/inventory/download_all', [InventoryController::class, 'download_all'])->name('inventory.download_all');
Route::get('/inventory/search', [InventoryController::class, 'search'])->name('inventory.search');
Route::get('/inventory/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
Route::get('/inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
Route::post('/inventory/import', [InventoryController::class, 'import'])->name('inventory.import');
Route::get('/inventory/{inventory}/history', [InventoryController::class, 'history'])->name('inventory.history');
Route::middleware('auth')->group(function () {
    Route::get('/inventory/daily-report', [InventoryController::class, 'dailyReport'])->name('inventory.daily-report');
});

Route::middleware('auth')->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
});

Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::patch('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/trucks', [TruckController::class, 'index'])->name('trucks.index');
});
// Route [trucks.create] not defined.
Route::get('/trucks/create', function () {
    return view('trucks.create');
})->name('trucks.create');
Route::post('/trucks', [TruckController::class, 'store'])->name('trucks.store');
Route::get('/trucks/{truck}', [TruckController::class, 'show'])->name('trucks.show');
Route::get('/trucks/{truck}/edit', [TruckController::class, 'edit'])->name('trucks.edit');
Route::patch('/trucks/{truck}', [TruckController::class, 'update'])->name('trucks.update');
Route::delete('/trucks/{truck}', [TruckController::class, 'destroy'])->name('trucks.destroy');
Route::get('/trucks/{truck}/print', [TruckController::class, 'print'])->name('trucks.print');
Route::get('/trucks/{truck}/download', [TruckController::class, 'download'])->name('trucks.download');
Route::get('/trucks/{truck}/pdf', [TruckController::class, 'pdf'])->name('trucks.pdf');



require __DIR__ . '/auth.php';


