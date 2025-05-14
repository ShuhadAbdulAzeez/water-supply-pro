<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('truck')->paginate(10);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $trucks = Truck::where('status', 'active')->get();
        return view('staff.create', compact('trucks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'role' => 'required|in:driver,helper,manager',
            'truck_id' => 'nullable|exists:trucks,id',
            'status' => 'required|in:active,inactive',
            'password' => 'required|min:8'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        Staff::create($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load('truck', 'bills');
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $trucks = Truck::where('status', 'active')->get();
        return view('staff.edit', compact('staff', 'trucks'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'required|string|max:20',
            'role' => 'required|in:driver,helper,manager',
            'truck_id' => 'nullable|exists:trucks,id',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|min:8'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $staff->update($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }
}