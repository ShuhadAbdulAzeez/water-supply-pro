<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Models\Inventory;
use App\Models\Truck;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BottleController extends Controller
{
    public function index()
    {
        $bottles = Bottle::with(['truck', 'customer'])->paginate(10);
        return view('bottles.index', compact('bottles'));
    }

    public function create()
    {
        return view('bottles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bottle_number' => 'required|unique:bottles',
            'size' => 'required|in:small,medium,large',
            'status' => 'required|in:filled,empty,damaged',
            'truck_id' => 'nullable|exists:trucks,id',
            'customer_id' => 'nullable|exists:customers,id'
        ]);

        Bottle::create($validated);

        return redirect()->route('bottles.index')
            ->with('success', 'Bottle created successfully.');
    }

    public function show(Bottle $bottle)
    {
        $bottle->load(['truck', 'customer', 'bills']);
        return view('bottles.show', compact('bottle'));
    }

    public function edit(Bottle $bottle)
    {
        $trucks = Truck::where('status', 'active')->get();
        $customers = Customer::where('status', 'active')->get();
        return view('bottles.edit', compact('bottle', 'trucks', 'customers'));
    }

    public function update(Request $request, Bottle $bottle)
    {
        $validated = $request->validate([
            'bottle_number' => 'required|unique:bottles,bottle_number,' . $bottle->id,
            'size' => 'required|in:small,medium,large',
            'status' => 'required|in:filled,empty,damaged',
            'truck_id' => 'nullable|exists:trucks,id',
            'customer_id' => 'nullable|exists:customers,id'
        ]);

        $bottle->update($validated);

        return redirect()->route('bottles.index')
            ->with('success', 'Bottle updated successfully.');
    }

    public function destroy(Bottle $bottle)
    {
        $bottle->delete();

        return redirect()->route('bottles.index')
            ->with('success', 'Bottle deleted successfully.');
    }

    public function markEmpty(Bottle $bottle)
    {
        $bottle->update(['status' => 'empty']);
        
        return redirect()->back()
            ->with('success', 'Bottle marked as empty successfully.');
    }

    public function markFilled(Bottle $bottle)
    {
        $bottle->update([
            'status' => 'filled',
            'last_returned_date' => now(),
        ]);

        return redirect()->route('bottles.show', $bottle)
            ->with('success', 'Bottle marked as filled.');
    }

    public function markDamaged(Bottle $bottle)
    {
        $bottle->update(['status' => 'damaged']);
        
        return redirect()->back()
            ->with('success', 'Bottle marked as damaged successfully.');
    }

    private function updateInventory($truckId, $quantity)
    {
        $inventory = Inventory::firstOrCreate(
            ['truck_id' => $truckId, 'inventory_date' => now()->toDateString()],
            [
                'filled_bottles_count' => 0,
                'empty_bottles_count' => 0,
                'damaged_bottles_count' => 0,
            ]
        );

        $inventory->filled_bottles_count += $quantity;
        $inventory->save();
    }
}