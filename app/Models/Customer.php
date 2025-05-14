<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'type',
        'credit_limit',
        'status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];

    public function bottles(): HasMany
    {
        return $this->hasMany(Bottle::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
} 