<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class VehicleEntryData
{
    /**
     * @param  ServiceItemData[]  $services
     * @param  ServiceItemData[]  $addons
     */
    public function __construct(
        public readonly ?string $jobOrderNo,
        public readonly string $entryDate,
        public readonly string $customerName,
        public readonly ?string $customerPhone,
        public readonly ?string $carModel,
        public readonly ?string $plateNumber,
        public readonly ?string $sma,
        public readonly array $services,
        public readonly array $addons,
        public readonly ?string $customerSignatureBase64,
        public readonly ?string $managerSignatureBase64,
    ) {
    }

    public static function fromRequest(array $validated): self
    {
        $services = collect($validated['services'] ?? [])
            ->values()
            ->map(fn (array $row, int $i) => ServiceItemData::fromArray($row, false, $i))
            ->all();

        $addons = collect($validated['addons'] ?? [])
            ->values()
            ->map(fn (array $row, int $i) => ServiceItemData::fromArray($row, true, $i))
            ->all();

        return new self(
            jobOrderNo: $validated['job_order_no'] ?? null,
            entryDate: $validated['entry_date'],
            customerName: trim($validated['customer_name']),
            customerPhone: $validated['phone_number'] ?? null,
            carModel: $validated['car_model'] ?? null,
            plateNumber: $validated['plate_number'] ?? null,
            sma: $validated['sma'] ?? null,
            services: $services,
            addons: $addons,
            customerSignatureBase64: $validated['customer_signature'] ?? null,
            managerSignatureBase64: $validated['manager_signature'] ?? null,
        );
    }

    /** @return ServiceItemData[] */
    public function allItems(): array
    {
        return [...$this->services, ...$this->addons];
    }

    public function totalAmount(): float
    {
        return collect($this->allItems())->sum(fn (ServiceItemData $item) => $item->price);
    }
}
