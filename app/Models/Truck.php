<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public static function getActiveTrucks()
    {
        return static::where('status', self::STATUS_ACTIVE)
                    ->orderBy('plate_number')
                    ->get();
    }
}