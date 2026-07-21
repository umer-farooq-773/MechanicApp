<?php

namespace App\Repositories\Contracts;

use App\Models\VehicleEntry;

interface VehicleEntryRepositoryInterface
{
    public function findOrFail(int $id): VehicleEntry;

    public function findWithRelations(int $id): VehicleEntry;

    public function createEntry(array $attributes): VehicleEntry;

    public function replaceServiceItems(VehicleEntry $entry, array $itemRows): void;

    public function nextJobOrderNumber(): string;
}
