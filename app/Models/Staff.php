<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'role',
        'truck_id',
        'status',
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
} 