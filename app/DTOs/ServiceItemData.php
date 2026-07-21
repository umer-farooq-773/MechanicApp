<?php

namespace App\DTOs;

class ServiceItemData
{
    public function __construct(
        public readonly string $nameEn,
        public readonly ?string $nameAr,
        public readonly float $price,
        public readonly ?string $remarks,
        public readonly bool $isAddon = false,
        public readonly int $sortOrder = 0,
    ) {
    }

    public static function fromArray(array $row, bool $isAddon, int $sortOrder): self
    {
        return new self(
            nameEn: trim($row['name_en'] ?? ''),
            nameAr: isset($row['name_ar']) ? trim($row['name_ar']) : null,
            price: (float) ($row['price'] ?? 0),
            remarks: isset($row['remarks']) ? trim($row['remarks']) : null,
            isAddon: $isAddon,
            sortOrder: $sortOrder,
        );
    }

    public function toArray(): array
    {
        return [
            'service_name_en' => $this->nameEn,
            'service_name_ar' => $this->nameAr,
            'price'           => $this->price,
            'remarks'         => $this->remarks,
            'is_addon'        => $this->isAddon,
            'sort_order'      => $this->sortOrder,
        ];
    }
}
