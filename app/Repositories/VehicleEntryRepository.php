<?php

namespace App\Repositories;

use App\Models\VehicleEntry;
use App\Repositories\Contracts\VehicleEntryRepositoryInterface;
use Illuminate\Support\Carbon;

class VehicleEntryRepository implements VehicleEntryRepositoryInterface
{
    public function findOrFail(int $id): VehicleEntry
    {
        return VehicleEntry::query()->findOrFail($id);
    }

    public function findWithRelations(int $id): VehicleEntry
    {
        return VehicleEntry::with(['customer', 'services', 'addons'])->findOrFail($id);
    }

    public function createEntry(array $attributes): VehicleEntry
    {
        return VehicleEntry::create($attributes);
    }

    public function replaceServiceItems(VehicleEntry $entry, array $itemRows): void
    {
        // Simple, scalable strategy for a form that fully re-submits its
        // rows each time: wipe and re-insert in one batched query instead
        // of diffing row-by-row. Cheap because line-item counts are small
        // (a handful of services/add-ons per job order).
        $entry->allItems()->delete();

        if (! empty($itemRows)) {
            $entry->allItems()->createMany($itemRows);
        }
    }

    public function nextJobOrderNumber(): string
    {
        $prefix = 'JO-' . now()->format('Ym') . '-';

        $lastNumber = VehicleEntry::query()
            ->where('job_order_no', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('job_order_no');

        $nextSeq = 1;

        if ($lastNumber) {
            $nextSeq = (int) substr($lastNumber, strlen($prefix)) + 1;
        }

        return $prefix . str_pad((string) $nextSeq, 4, '0', STR_PAD_LEFT);
    }
}
