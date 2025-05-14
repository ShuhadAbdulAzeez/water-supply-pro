<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bill extends Model
{
    protected $fillable = [
        'bill_number',
        'customer_id',
        'staff_id',
        'truck_id',
        'bottles_delivered',
        'empty_bottles_collected',
        'amount',
        'payment_status',
        'payment_method',
        'notes',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'bottles_delivered' => 'integer',
        'empty_bottles_collected' => 'integer',
        'status' => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function bottles(): BelongsToMany
    {
        return $this->belongsToMany(Bottle::class)
            ->withPivot('action')
            ->withTimestamps();
    }
}