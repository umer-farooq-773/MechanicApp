<?php

use App\Support\PdfDocumentSupport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

test('it renders a job order pdf with arabic services', function () {
    $entry = (object) [
        'job_order_no' => 'JO-202607-0001',
        'entry_date' => Carbon::parse('2026-07-10'),
        'car_model' => 'Toyota Land Cruiser',
        'plate_number' => '123456',
        'sma' => 'SMA-1',
        'total_amount' => 250,
        'customer_signature_path' => null,
        'manager_signature_path' => null,
        'customer' => (object) [
        'name' => 'Ahmed Customer',
        'phone' => '+97477771065',
        ],
        'services' => collect([
            (object) [
                'service_name_en' => 'Polishing',
                'service_name_ar' => 'تلميع السيارة',
                'price' => 250,
                'remarks' => 'Front and rear',
            ],
        ]),
        'addons' => collect(),
    ];

    $support = app(PdfDocumentSupport::class);
    $support->prepareDompdfStorage();

    $pdf = Pdf::loadView('vehicle.pdf', [
        'entry' => $entry,
        'pdfSupport' => $support,
    ])->setPaper('a4', 'portrait');

    expect($pdf->output())->toStartWith('%PDF');
});
