<?php

use App\Support\PdfDocumentSupport;

test('it shapes arabic text for dompdf rendering', function () {
    $support = new PdfDocumentSupport;

    $shaped = $support->arabic('ملف خدمة');

    expect($shaped)
        ->not->toBe('ملف خدمة')
        ->toContain('ﺔﻣﺪﺧ')
        ->toEndWith('ﻒﻠﻣ');
});
