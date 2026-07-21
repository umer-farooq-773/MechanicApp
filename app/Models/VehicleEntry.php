<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'job_order_no',
        'entry_date',
        'car_model',
        'plate_number',
        'sma',
        'total_amount',
        'customer_signature_path',
        'manager_signature_path',
        'status',
    ];

    protected $casts = [
        'entry_date'   => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(VehicleEntryService::class)
            ->where('is_addon', false)
            ->orderBy('sort_order');
    }

    public function addons(): HasMany
    {
        return $this->hasMany(VehicleEntryService::class)
            ->where('is_addon', true)
            ->orderBy('sort_order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(VehicleEntryService::class)->orderBy('sort_order');
    }

    public function customerSignatureUrl(): ?string
    {
        return $this->customer_signature_path
            ? asset('storage/' . $this->customer_signature_path)
            : null;
    }

    public function managerSignatureUrl(): ?string
    {
        return $this->manager_signature_path
            ? asset('storage/' . $this->manager_signature_path)
            : null;
    }
}
