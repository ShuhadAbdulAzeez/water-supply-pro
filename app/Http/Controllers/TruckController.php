<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::with('staff')->paginate(10);
        return view('trucks.index', compact('trucks'));
    }

    public function create()
    {
        return view('trucks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|unique:trucks',
            'model' => 'required',
            'capacity' => 'required|numeric',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        Truck::create($validated);

        return redirect()->route('trucks.index')
            ->with('success', 'Truck created successfully.');
    }

    public function show(Truck $truck)
    {
        $truck->load(['staff', 'bottles', 'bills', 'inventory']);
        return view('trucks.show', compact('truck'));
    }

    public function edit(Truck $truck)
    {
        return view('trucks.edit', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'plate_number' => 'required|unique:trucks,plate_number,' . $truck->id,
            'model' => 'required',
            'capacity' => 'required|numeric',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        $truck->update($validated);

        return redirect()->route('trucks.index')
            ->with('success', 'Truck updated successfully.');
    }

    public function destroy(Truck $truck)
    {
        $truck->delete();

        return redirect()->route('trucks.index')
            ->with('success', 'Truck deleted successfully.');
    }
}