<?php

namespace App\Services;

use App\DTOs\VehicleEntryData;
use App\Models\Customer;
use App\Models\VehicleEntry;
use App\Repositories\Contracts\VehicleEntryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleEntryFormService
{
    public function __construct(
        private readonly VehicleEntryRepositoryInterface $repository,
    ) {
    }

    public function store(VehicleEntryData $data): VehicleEntry
    {
        return DB::transaction(function () use ($data) {
            $customer = Customer::query()->firstOrCreate(
                ['name' => $data->customerName, 'phone' => $data->customerPhone],
                ['name' => $data->customerName, 'phone' => $data->customerPhone],
            );

            $entry = $this->repository->createEntry([
                'customer_id'    => $customer->id,
                'job_order_no'   => $data->jobOrderNo ?: $this->repository->nextJobOrderNumber(),
                'entry_date'     => $data->entryDate,
                'car_model'      => $data->carModel,
                'plate_number'   => $data->plateNumber,
                'sma'            => $data->sma,
                'total_amount'   => $data->totalAmount(),
                'status'         => 'submitted',
            ]);

            $itemRows = array_map(fn ($item) => $item->toArray(), $data->allItems());
            $this->repository->replaceServiceItems($entry, $itemRows);

            if ($data->customerSignatureBase64) {
                $entry->customer_signature_path = $this->storeSignature(
                    $data->customerSignatureBase64,
                    "signatures/{$entry->id}-customer"
                );
            }

            if ($data->managerSignatureBase64) {
                $entry->manager_signature_path = $this->storeSignature(
                    $data->managerSignatureBase64,
                    "signatures/{$entry->id}-manager"
                );
            }

            if ($entry->isDirty()) {
                $entry->save();
            }

            return $entry->fresh(['customer', 'services', 'addons']);
        });
    }

    /**
     * Decode a "data:image/png;base64,...." canvas payload and store it as
     * a real PNG file on the public disk. Storing a real file (rather than
     * the base64 string in the DB) keeps rows small and lets DomPDF read
     * the signature straight off disk via public_path(), which is the
     * reliable path for DomPDF image rendering (HTTP URLs are not).
     */
    private function storeSignature(string $base64, string $pathWithoutExtension): string
    {
        if (! preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $base64, $matches)) {
            throw new \InvalidArgumentException('Invalid signature image payload.');
        }

        $extension = $matches[1] === 'jpg' ? 'jpeg' : $matches[1];
        $binary = base64_decode(substr($base64, strpos($base64, ',') + 1));

        $relativePath = "{$pathWithoutExtension}-" . Str::random(8) . ".{$extension}";

        Storage::disk('public')->put($relativePath, $binary);

        return $relativePath;
    }
}
