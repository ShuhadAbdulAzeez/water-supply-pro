<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class DailyInventoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        $today = Carbon::today();
        
        return Inventory::with('truck')
            ->whereDate('created_at', $today)
            ->orWhereDate('inventory_date', $today)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date & Time',
            'Truck Plate',
            'Filled Bottles',
            'Empty Bottles',
            'Damaged Bottles',
            'Total Bottles',
            'Notes'
        ];
    }

    public function map($row): array
    {
        // Add error handling for relationships
        $truckPlate = $row->truck ? $row->truck->plate_number : 'N/A';
        
        return [
            $row->created_at->format('Y-m-d H:i:s'),
            $truckPlate,
            $row->filled_bottles_count ?? 0,
            $row->empty_bottles_count ?? 0,
            $row->damaged_bottles_count ?? 0,
            ($row->filled_bottles_count ?? 0) + 
            ($row->empty_bottles_count ?? 0) + 
            ($row->damaged_bottles_count ?? 0),
            $row->notes ?? ''
        ];
    }
}