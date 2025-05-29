<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Truck extends Model
{
    protected $fillable = [
        'plate_number',
        'model',
        'status'
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_MAINTENANCE = 'maintenance';

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    // Simple one-to-many relationship (staff belongs to truck)
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    // Get active staff members assigned to this truck
    public function activeStaff(): HasMany
    {
        return $this->hasMany(Staff::class)->where('is_active', true);
    }

    // Get the current driver
    public function currentDriver(): HasOne
    {
        return $this->hasOne(Staff::class)
                    ->where('role', 'driver')
                    ->where('is_active', true);
    }

    public static function getActiveTrucks()
    {
        return static::where('status', self::STATUS_ACTIVE)
            ->orderBy('plate_number')
            ->get();
    }

    public static function getTrucksWithActiveStaff()
    {
        return static::whereHas('activeStaff')
            ->where('status', self::STATUS_ACTIVE)
            ->with(['activeStaff'])
            ->orderBy('plate_number')
            ->get();
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInMaintenance(): bool
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    public function hasActiveDriver(): bool
    {
        return $this->currentDriver()->exists();
    }

    public function bottles(): HasMany
    {
        return $this->hasMany(Bottle::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}