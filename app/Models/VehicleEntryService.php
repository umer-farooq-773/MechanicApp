<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleEntryService extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_entry_id',
        'service_name_en',
        'service_name_ar',
        'price',
        'remarks',
        'is_addon',
        'sort_order',
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'is_addon' => 'boolean',
    ];

    public function vehicleEntry(): BelongsTo
    {
        return $this->belongsTo(VehicleEntry::class);
    }
}
