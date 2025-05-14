<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Truck;
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
        $trucks = Truck::getActiveTrucks();
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
        $today = now()->toDateString();
        $inventories = Inventory::with('truck')
            ->whereDate('inventory_date', $today)
            ->get();

        $summary = [
            'total_filled' => $inventories->sum('filled_bottles_count'),
            'total_empty' => $inventories->sum('empty_bottles_count'),
            'total_damaged' => $inventories->sum('damaged_bottles_count'),
            'total_bottles' => $inventories->sum(function ($inventory) {
                return $inventory->filled_bottles_count + 
                       $inventory->empty_bottles_count + 
                       $inventory->damaged_bottles_count;
            })
        ];

        return view('inventory.daily-report', compact('inventories', 'summary', 'today'));
    }
}