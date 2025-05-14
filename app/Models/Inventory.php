<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = 'inventory';

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
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }
} 