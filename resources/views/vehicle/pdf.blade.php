<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Job Order {{ $entry->job_order_no }}</title>
    @php
        $cairoFontDataUri = $pdfSupport->publicDataUri('fonts/Cairo-Regular.ttf');
        $logoDataUri = $pdfSupport->publicDataUri('assets/logo/logo.png');
        $diagramDataUri = $pdfSupport->publicDataUri('assets/vehicle/inspection-diagram.jpeg');
        $customerSignatureDataUri = $pdfSupport->publicDiskDataUri($entry->customer_signature_path);
        $managerSignatureDataUri = $pdfSupport->publicDiskDataUri($entry->manager_signature_path);

        // Workaround for a DomPDF/CPDF bidi quirk: PdfDocumentSupport::arabic()
        // reverses the character order to force correct RTL glyph order, but
        // that also flips any embedded LTR punctuation (parentheses, etc.).
        // Swapping the bracket characters before reshaping cancels that out,
        // so "(ذ.م.م)" renders as "(ذ.م.م)" instead of ")ذ.م.م(".
        $arBrand = strtr('سبيشل تاتش للعناية بالسيارات (ذ.م.م)', ['(' => ')', ')' => '(']);
    @endphp
    <style>
        @if($cairoFontDataUri)
        @font-face {
            font-family: 'Cairo';
            src: url('{{ $cairoFontDataUri }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @endif

        @page {
            size: A4 portrait;
            margin: 18mm 14mm 24mm 14mm;
        }

        html, body {
            height: 100%;
            font-family: 'Cairo', DejaVu Sans, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .rtl-text,
        .ar-brand,
        .title-row .job-ar,
        .service-ar,
        .notice-box .ar {
            direction: rtl;
            unicode-bidi: embed;
            font-family: 'Cairo', DejaVu Sans, sans-serif;
        }

        body {
            color: #0E2038;
            font-size: 12px;
            margin: 0;
            padding-bottom: 38mm;
        }

        .job-card {
            width: 100%;
            padding: 18px 0 0;
            margin: 0 auto;
            position: relative;
        }

        .footer {
            font-size: 9px;
            font-weight: bold;
            color: #00204a;
            text-align: center;
            position: fixed;
            left: 14mm;
            right: 14mm;
            bottom: 12mm;
            padding-top: 6px;
            border-top: 1px solid #cbd5e1;
            background-color: white;
        }

        .header-main {
            text-align: center;
            margin-bottom: 5px;
        }

        table.header-table {
            border-collapse: collapse;
            margin: 0 auto;
            width: auto;
        }

        table.header-table td {
            vertical-align: middle;
            padding: 0 8px;
        }

        .header-logo img {
            width: 120px;
            height: auto;
            display: block;
        }

        .ar-brand {
            font-size: 20px;
            font-weight: bold;
            color: #00204a;
            text-align: center;
            margin-bottom: 2px;
        }

        .en-brand {
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            color: #3b82f6;
            text-align: center;
        }

        .header-line-divider {
            width: 100%;
            height: 2px;
            background-color: #3b82f6;
            margin-top: 10px;
            margin-bottom: 18px;
        }

        .title-row {
            text-align: center;
            margin-top: 12px;
        }

        .title-row .job-en,
        .title-row .job-ar {
            font-weight: bold;
            font-size: 26px;
            color: #00204a;
        }

        .badge-wrapper {
            text-align: center;
            margin: 10px 0 18px 0;
        }

        .badge-june {
            background-color: #00204a;
            color: white;
            font-weight: bold;
            font-size: 14px;
            padding: 6px 30px;
            display: inline-block;
        }

        table.info-grid {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #00204a;
            margin-bottom: 18px;
        }

        table.info-grid td {
            padding: 8px 12px;
            vertical-align: top;
            font-size: 11px;
            border-right: 1.5px solid #00204a;
        }

        table.info-grid td:last-child {
            border-right: none;
        }

        .info-row-line {
            margin-bottom: 6px;
        }

        .info-row-line .label {
            font-weight: bold;
            color: #000;
        }

        .info-row-line .val {
            color: #333;
        }

        table.table-services {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 4px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        table.table-services thead th {
            background-color: #00204a;
            color: white;
            font-weight: bold;
            padding: 8px 10px;
            text-align: center;
            border: 1px solid #00204a;
        }

        table.table-services tbody tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .service-name-split,
        .signatures-table,
        .notice-box,
        .total-table {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        table.table-services tbody td {
            padding: 6px 10px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }

        /* Bilingual service-name split: English left / Arabic right, on one
           line, using a borderless inner table (flexbox is unreliable on
           DomPDF's CPDF backend, tables are not). Replaces the old stacked
           "English above, Arabic below-right" layout that read as cramped. */
        table.service-name-split {
            width: 100%;
            border-collapse: collapse;
        }

        table.service-name-split td {
            border: none !important;
            padding: 0 !important;
            vertical-align: middle;
            width: 50%;
        }

        .service-name {
            font-weight: bold;
            display: block;
            text-align: left;
            font-size: 10px;
        }

        .service-ar {
            font-weight: bold;
            display: block;
            text-align: right;
            font-size: 11px;
        }

        .price-col {
            width: 18%;
            text-align: center;
            font-weight: bold;
        }

        .remarks-col {
            width: 32%;
        }

        .addons-heading {
            font-weight: bold;
            font-size: 11px;
            color: #00204a;
            text-transform: uppercase;
            margin: 14px 0 4px;
        }

        table.total-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        table.total-table td {
            background-color: #00204a;
            color: white;
            padding: 8px 15px;
            border: 1px solid #00204a;
            font-weight: bold;
            font-size: 12px;
            text-align: right;
        }

        .vehicle-diagram {
            width: 100%;
            margin: 18px 0 8px;
            text-align: center;
        }

        .vehicle-diagram img {
            width: 100%;
            max-height: 240px;
            object-fit: contain;
            border: 1px solid #cbd5e1;
        }

        .signatures-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }

        .signatures-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .signatures-table td {
            width: 50%;
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: center;
            vertical-align: bottom;
            height: 105px;
        }

        .signatures-table .label {
            font-weight: bold;
            font-size: 10px;
            display: block;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .signatures-table img {
            max-height: 70px;
            max-width: 90%;
        }

        .notice-box {
            background-color: #e2e8f0;
            padding: 12px 16px;
            color: #0f172a;
            text-align: center;
            margin: 16px 0 32px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .notice-box .ar {
            font-weight: bold;
            font-size: 12px;
            display: block;
            margin-bottom: 4px;
        }

        .notice-box .en {
            font-weight: normal;
            font-size: 9px;
            color: #334155;
            display: block;
        }

        .footer {
            font-size: 9px;
            font-weight: bold;
            color: #00204a;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="job-card">
        <div class="header-main">
            <table class="header-table">
                <tr>
                    @if($logoDataUri)
                        <td class="header-logo">
                            <img src="{{ $logoDataUri }}" alt="Special Touch Car Care Logo">
                        </td>
                    @endif
                    <td class="header-brand">
                        <div class="ar-brand">{{ $pdfSupport->arabic($arBrand) }}</div>
                        <div class="en-brand">SPECIAL TOUCH CAR CARE W.L.L</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="header-line-divider"></div>

        <div class="title-row">
            <span class="job-en">JOB ORDER</span>&nbsp;&nbsp;
            <span class="job-ar">{{ $pdfSupport->arabic('ملف خدمة') }}</span>
        </div>

        <div class="badge-wrapper">
            <span class="badge-june">{{ strtoupper($entry->entry_date->format('F Y')) }}</span>
        </div>

        <table class="info-grid">
            <tr>
                <td style="width: 27%;">
                    <div class="info-row-line"><span class="label">Job Order:</span> <span class="val">{{ $entry->job_order_no }}</span></div>
                    <div class="info-row-line"><span class="label">Date:</span> <span class="val">{{ $entry->entry_date->format('d-m-Y') }}</span></div>
                </td>
                <td style="width: 43%;">
                    <div class="info-row-line"><span class="label">Customer:</span> <span class="val">{{ $entry->customer->name }}</span></div>
                    <div class="info-row-line"><span class="label">Car Model:</span> <span class="val">{{ $entry->car_model }}</span></div>
                    <div class="info-row-line"><span class="label">Plate Number:</span> <span class="val">{{ $entry->plate_number }}</span></div>
                </td>
                <td style="width: 30%;">
                    <div class="info-row-line"><span class="label">Phone Number:</span> <span class="val">{{ $entry->customer->phone }}</span></div>
                    <div class="info-row-line"><span class="label">SMA:</span> <span class="val">{{ $entry->sma }}</span></div>
                </td>
            </tr>
        </table>

        <table class="table-services">
            <thead>
                <tr>
                    <th style="width: 50%;">Service</th>
                    <th style="width: 18%;">Price</th>
                    <th style="width: 32%;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entry->services as $service)
                    <tr>
                        <td>
                            <table class="service-name-split">
                                <tr>
                                    <td>
                                        <span class="service-name">{{ $service->service_name_en }}</span>
                                    </td>
                                    <td class="rtl-text">
                                        @if($service->service_name_ar)
                                            <span class="service-ar">{{ $pdfSupport->arabic($service->service_name_ar) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="price-col">{{ number_format($service->price, 2) }}</td>
                        <td class="remarks-col">{{ $service->remarks }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">No services recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($entry->addons->isNotEmpty())
            <div class="addons-heading">Add-Ons</div>
            <table class="table-services">
                <tbody>
                    @foreach($entry->addons as $addon)
                        <tr>
                            <td>
                                <table class="service-name-split">
                                    <tr>
                                        <td>
                                            <span class="service-name">{{ $addon->service_name_en }}</span>
                                        </td>
                                        <td class="rtl-text">
                                            @if($addon->service_name_ar)
                                                <span class="service-ar">{{ $pdfSupport->arabic($addon->service_name_ar) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="price-col">{{ number_format($addon->price, 2) }}</td>
                            <td class="remarks-col">{{ $addon->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <table class="total-table">
            <tr>
                <td>TOTAL:&nbsp; {{ number_format($entry->total_amount, 2) }}</td>
            </tr>
        </table>

        @if($diagramDataUri)
            <div class="vehicle-diagram">
                <img src="{{ $diagramDataUri }}" alt="Vehicle inspection diagram">
            </div>
        @endif

        <table class="signatures-table">
            <tr>
                <td>
                    <span class="label">CUSTOMER SIGNATURE</span>
                    @if($customerSignatureDataUri)
                        <img src="{{ $customerSignatureDataUri }}" alt="Customer Signature">
                    @endif
                </td>
                <td>
                    <span class="label">MANAGER SIGNATURE</span>
                    @if($managerSignatureDataUri)
                        <img src="{{ $managerSignatureDataUri }}" alt="Manager Signature">
                    @endif
                </td>
            </tr>
        </table>

        <div class="notice-box">
            <span class="ar">{{ $pdfSupport->arabic('ملاحظة: الرجاء أخذ كامل الأغراض الخاصة بك لأن المحل غير مسؤول عن أي مستلزمات داخل المركبة.') }}</span>
            <span class="en">Important Notice: Please take all your belongings with you as the store is not responsible for any supplies inside the vehicle. The car is all painted and the shop is not responsibility if painted removed.</span>
        </div>

        <div class="footer">
            Building, 423, Street 340, Zone 56. Doha, Qatar &nbsp;|&nbsp; www.zpecial-touch.com &nbsp;|&nbsp; info@special-touch.com &nbsp;|&nbsp; +974 7777 1065
        </div>
    </div>
</body>
</html>
