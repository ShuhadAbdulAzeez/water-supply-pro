<?php
namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\Truck;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalCustomers' => Customer::count(),
            'activeBottles' => Bottle::where('status', 'filled')->count(),
            'pendingDeliveries' => Bottle::whereNotNull('customer_id')
                                    ->where('status', 'filled')->count(),
            'monthlyRevenue' => Bill::whereMonth('created_at', Carbon::now()->month)
                                ->sum('amount'),
            'availableTrucks' => Truck::where('status', 'active')->count(),
            'emptyBottles' => Bottle::where('status', 'empty')->count(),
            'damagedBottles' => Bottle::where('status', 'damaged')->count(),
            'unpaidBills' => Bill::where('status', 'unpaid')->count(),
        ];

        return view('dashboard', compact('data'));
    }
}