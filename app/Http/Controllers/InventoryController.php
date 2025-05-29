<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Truck;
use App\Exports\DailyInventoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('truck')->paginate(10);
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        $trucks = Truck::where('status', 'active')
                    ->orderBy('plate_number')
                    ->get();
        
        // Check if trucks are being retrieved
        if ($trucks->isEmpty()) {
            // Log that no active trucks were found
            \Log::info('No active trucks found in database');
        } else {
            // Log how many trucks were found
            \Log::info('Found ' . $trucks->count() . ' active trucks');
        }
                    
        return view('inventory.create', compact('trucks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'filled_bottles_count' => 'required|integer|min:0',
            'empty_bottles_count' => 'required|integer|min:0',
            'damaged_bottles_count' => 'required|integer|min:0',
            'inventory_date' => 'required|date'
        ]);

        Inventory::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory record created successfully.');
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('truck');
        return view('inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $trucks = Truck::where('status', 'active')->get();
        return view('inventory.edit', compact('inventory', 'trucks'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'filled_bottles_count' => 'required|integer|min:0',
            'empty_bottles_count' => 'required|integer|min:0',
            'damaged_bottles_count' => 'required|integer|min:0',
            'inventory_date' => 'required|date'
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory record updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory record deleted successfully.');
    }

    public function truckInventory(Truck $truck)
    {
        $inventories = Inventory::where('truck_id', $truck->id)
            ->latest('inventory_date')
            ->paginate(10);
        return view('inventory.truck', compact('truck', 'inventories'));
    }

    public function dailyReport()
    {
        try {
            $today = Carbon::today();
            
            // Get all records for today with debugging
            $records = Inventory::whereDate('created_at', $today)
                              ->orWhereDate('inventory_date', $today)
                              ->with('truck')
                              ->get();
            
            if ($records->isEmpty()) {
                \Log::info('No inventory records found for: ' . $today->format('Y-m-d'));
                return redirect()->back()
                    ->with('error', 'No inventory records found for ' . $today->format('Y-m-d'));
            }

            $fileName = 'inventory-daily-report-' . $today->format('Y-m-d') . '.xlsx';
            return Excel::download(new DailyInventoryExport, $fileName);
            
        } catch (\Exception $e) {
            \Log::error('Excel export failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }
}