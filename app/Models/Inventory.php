<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'truck_id',
        'filled_bottles_count',
        'empty_bottles_count',
        'damaged_bottles_count',
        'inventory_date',
        'notes',
    ];

    protected $casts = [
        'inventory_date' => 'date',
        'filled_bottles_count' => 'integer',
        'empty_bottles_count' => 'integer',
        'damaged_bottles_count' => 'integer',
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    // Helper methods
    public function getTotalBottlesAttribute(): int
    {
        return $this->filled_bottles_count + $this->empty_bottles_count + $this->damaged_bottles_count;
    }

    public function getUsableBottlesAttribute(): int
    {
        return $this->filled_bottles_count + $this->empty_bottles_count;
    }

    public function getDamagePercentageAttribute(): float
    {
        $total = $this->getTotalBottlesAttribute();
        return $total > 0 ? round(($this->damaged_bottles_count / $total) * 100, 2) : 0;
    }

    // Scopes
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('inventory_date', $date);
    }

    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('inventory_date', [$startDate, $endDate]);
    }

    public function scopeForTruck($query, $truckId)
    {
        return $query->where('truck_id', $truckId);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('inventory_date', 'desc');
    }

    // Static methods
    public static function getLatestForTruck($truckId)
    {
        return static::where('truck_id', $truckId)
                    ->orderBy('inventory_date', 'desc')
                    ->first();
    }

    public static function getTodaysInventories()
    {
        return static::whereDate('inventory_date', Carbon::today())
                    ->with('truck')
                    ->orderBy('inventory_date', 'desc')
                    ->get();
    }

    public static function getInventorySummaryForDate($date)
    {
        return static::whereDate('inventory_date', $date)
                    ->selectRaw('
                        COUNT(*) as total_trucks,
                        SUM(filled_bottles_count) as total_filled,
                        SUM(empty_bottles_count) as total_empty,
                        SUM(damaged_bottles_count) as total_damaged,
                        AVG(filled_bottles_count) as avg_filled_per_truck
                    ')
                    ->first();
    }
}