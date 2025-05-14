<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bottle;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Staff;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with(['customer', 'staff'])->paginate(10);
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $staff = Staff::where('status', 'active')->get();
        $trucks = Truck::where('status', 'active')->get();
        return view('bills.create', compact('customers', 'staff', 'trucks'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'staff_id' => 'required|exists:staff,id',
                'truck_id' => 'required|exists:trucks,id',
                'bottles_delivered' => 'required|integer|min:1',
                'empty_bottles_collected' => 'required|integer|min:0',
                'amount' => 'required|numeric|min:0',
                'payment_method' => 'required|in:cash,credit,card',
                'payment_status' => 'required|in:pending,paid,cancelled',
                'notes' => 'nullable|string'
            ]);

            $validated['bill_number'] = 'BILL-' . strtoupper(uniqid());
            
            // Debug the data being saved
            \Log::info('Creating bill with data:', $validated);
            
            $bill = Bill::create($validated);
            
            if (!$bill) {
                \Log::error('Failed to create bill');
                return back()->with('error', 'Failed to create bill. Please try again.');
            }

            // Update bottle statuses
            $this->updateBottleStatuses($bill);

            // Update inventory
            $this->updateInventory($bill);

            return redirect()->route('bills.index')
                ->with('success', 'Bill created successfully.');
                
        } catch (\Exception $e) {
            \Log::error('Error creating bill: ' . $e->getMessage());
            return back()->with('error', 'Error creating bill: ' . $e->getMessage());
        }
    }

    public function show(Bill $bill)
    {
        $bill->load(['customer', 'staff', 'truck']);
        return view('bills.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        $customers = Customer::where('status', 'active')->get();
        $staff = Staff::where('status', 'active')->get();
        $trucks = Truck::where('status', 'active')->get();
        return view('bills.edit', compact('bill', 'customers', 'staff', 'trucks'));
    }

    public function update(Request $request, Bill $bill)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'staff_id' => 'required|exists:staff,id',
            'truck_id' => 'required|exists:trucks,id',
            'bottles_delivered' => 'required|integer|min:1',
            'empty_bottles_collected' => 'required|integer|min:0',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,credit,card',
            'payment_status' => 'required|in:paid,pending,overdue',
            'notes' => 'nullable|string'
        ]);

        $bill->update($validated);

        // Update bottle statuses
        $this->updateBottleStatuses($bill);

        // Update inventory
        $this->updateInventory($bill);

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Bill updated successfully.');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();

        return redirect()->route('bills.index')
            ->with('success', 'Bill deleted successfully.');
    }

    public function print(Bill $bill)
    {
        $bill->load(['customer', 'staff', 'truck']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bills.print', compact('bill'));
        return $pdf->stream('bill-' . $bill->bill_number . '.pdf');
    }

    private function updateBottleStatuses(Bill $bill)
    {
        // Get bottles to be delivered
        $bottlesToDeliver = Bottle::where('truck_id', $bill->truck_id)
            ->where('status', 'filled')
            ->take($bill->bottles_delivered)
            ->get();

        // Get bottles to be collected
        $bottlesToCollect = Bottle::where('customer_id', $bill->customer_id)
            ->where('status', 'empty')
            ->take($bill->empty_bottles_collected)
            ->get();

        // Attach bottles to bill with appropriate actions
        foreach ($bottlesToDeliver as $bottle) {
            $bill->bottles()->attach($bottle->id, ['action' => 'delivered']);
            $bottle->update([
                'customer_id' => $bill->customer_id,
                'status' => 'empty',
                'last_filled_date' => now(),
            ]);
        }

        foreach ($bottlesToCollect as $bottle) {
            $bill->bottles()->attach($bottle->id, ['action' => 'collected']);
            $bottle->update([
                'truck_id' => $bill->truck_id,
                'status' => 'filled',
                'last_returned_date' => now(),
            ]);
        }
    }

    private function updateInventory(Bill $bill)
    {
        $inventory = Inventory::firstOrCreate(
            ['truck_id' => $bill->truck_id, 'inventory_date' => now()->toDateString()],
            [
                'filled_bottles_count' => 0,
                'empty_bottles_count' => 0,
                'damaged_bottles_count' => 0,
            ]
        );

        $inventory->filled_bottles_count -= $bill->bottles_delivered;
        $inventory->empty_bottles_count += $bill->empty_bottles_collected;
        $inventory->save();
    }
} 