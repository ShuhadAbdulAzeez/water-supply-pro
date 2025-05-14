<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bottle extends Model
{
    protected $fillable = [
        'bottle_number',
        'status',
        'size',
        'truck_id',
        'customer_id',
        'last_filled_date',
        'last_returned_date',
    ];

    protected $casts = [
        'last_filled_date' => 'date',
        'last_returned_date' => 'date',
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class)
            ->withPivot('action')
            ->withTimestamps();
    }
}