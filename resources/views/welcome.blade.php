<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Special Touch Car Care – Job Order</title>
  <!-- Bootstrap 5 + Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      background: #e6e9ef;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      padding: 24px;
    }
    .job-card {
      max-width: 1100px;
      width: 100%;
      background: #ffffff;
      border-radius: 28px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
      padding: 28px 30px 20px;
    }
    /* ----- HEADER (exact match to uploaded image) ----- */
    .header-main {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 4px;
      flex-wrap: wrap;
    }
    .header-left {
      flex: 0 0 auto;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .logo-icon {
      width: 48px;
      height: 48px;
      background: #0b2a4a;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 22px;
      font-weight: 700;
    }
    .header-center {
      flex: 1 1 auto;
      text-align: center;
      padding: 0 10px;
    }
    .header-center .ar-brand {
      font-size: 18px;
      font-weight: 700;
      color: #0b2a4a;
      direction: rtl;
      line-height: 1.2;
      letter-spacing: 0.3px;
    }
    .header-center .en-brand {
      font-weight: 700;
      font-size: 22px;
      letter-spacing: -0.2px;
      color: #0b2a4a;
      line-height: 1.2;
    }
    .header-right {
      flex: 0 0 auto;
      text-align: right;
    }
    .sep-line {
      border: none;
      height: 2px;
      background: #0b2a4a;
      margin: 4px 0 4px 0;
      opacity: 0.8;
    }
    .title-row {
      display: flex;
      align-items: baseline;
      justify-content: center;
      flex-wrap: wrap;
      column-gap: 8px;
      row-gap: 2px;
      margin-top: 4px;
    }
    .title-row .job-en {
      font-weight: 700;
      font-size: 28px;
      letter-spacing: 1px;
      color: #0b2a4a;
      line-height: 1;
    }
    .title-row .job-ar {
      font-size: 20px;
      font-weight: 600;
      color: #0b2a4a;
      direction: rtl;
    }
    .badge-june {
      background: #1d6f9c;
      color: white;
      font-weight: 700;
      font-size: 18px;
      padding: 2px 22px;
      border-radius: 30px;
      display: inline-block;
      letter-spacing: 0.5px;
      margin:5px auto;
    }
    .badge-wrapper {
      text-align: center;
      margin-top: 2px;
    }

    /* ----- customer info (exact 3 columns, vertical dividers) ----- */
    .info-grid-exact {
      border: 2px solid #0b2a4a;
      border-radius: 16px;
      padding: 12px 16px;
      background: #fafcff;
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .info-col {
      flex: 1 1 0;
      padding: 0 8px;
      border-right: 2px solid #b8c9dd;
    }
    .info-col:last-child {
      border-right: none;
    }
    .info-row {
      display: flex;
      align-items: baseline;
      padding: 4px 0;
    }
    .info-row .label {
      font-weight: 700;
      font-size: 14px;
      color: #0b2a4a;
      letter-spacing: 0.2px;
      min-width: 80px;
    }
    .info-row .value {
      font-weight: 500;
      font-size: 14px;
      color: #1a2e44;
      border-bottom: 1px dashed #b0c4d9;
      flex: 1;
      margin-left: 4px;
      padding-bottom: 1px;
    }

    /* service table (already correct) */
    .table-services {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      border: 2px solid #0b2a4a;
      border-radius: 16px;
      overflow: hidden;
      margin-bottom: 16px;
    }
    .table-services thead th {
      background: #0b2a4a;
      color: white;
      font-weight: 700;
      padding: 10px 12px;
      border: 1px solid #0b2a4a;
      text-align: left;
    }
    .table-services tbody td {
      padding: 10px 12px;
      border: 1px solid #b8c9dd;
      vertical-align: middle;
    }
    .table-services tbody tr:nth-child(even) { background: #f2f5fa; }
    .table-services tbody tr:nth-child(odd) { background: #ffffff; }
    .service-name { font-weight: 600; color: #0b2a4a; }
    .service-ar { font-weight: 400; color: #2c3e5a; margin-left: 10px; font-size: 13px; }
    .price-col { font-weight: 600; color: #0b2a4a; width: 100px; }
    .total-row td {
      background: #0b2a4a !important;
      color: white !important;
      font-weight: 700;
      font-size: 18px;
      padding: 10px 12px;
      border: 1px solid #0b2a4a;
    }
    .total-row .total-label { text-align: right; padding-right: 20px; }
    .total-row .total-value { text-align: center; letter-spacing: 1px; }

    /* bottom grid: left (vehicles) + right (signatures) */
    .vehicle-box {
      border: 2px solid #0b2a4a;
      border-radius: 14px;
      padding: 10px 6px;
      background: #fafcff;
      text-align: center;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100px;
    }
    .vehicle-box svg {
      width: 100%;
      max-width: 100px;
      height: auto;
      stroke: #0b2a4a;
      stroke-width: 2;
      fill: none;
    }
    .vehicle-box .v-label {
      font-size: 13px;
      font-weight: 600;
      color: #0b2a4a;
      margin-top: 4px;
    }
    .sig-box {
      border: 2px solid #0b2a4a;
      border-radius: 14px;
      padding: 12px 16px;
      background: #fafcff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100%;
      min-height: 58px;
      flex-wrap: wrap;
    }
    .sig-box .label {
      font-weight: 700;
      color: #0b2a4a;
      font-size: 15px;
    }
    .sig-box .line {
      border-bottom: 2px solid #b0c4d9;
      flex: 1;
      margin-left: 12px;
      min-width: 40px;
    }
    .empty-box {
      border: 2px solid #0b2a4a;
      border-radius: 14px;
      background: #fafcff;
      height: 100%;
      min-height: 58px;
    }

    /* notice (already correct) */
    .notice-box {
      background: #ededed;
      border-radius: 30px;
      padding: 12px 24px;
      color: #0b2a4a;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      margin: 16px 0 14px 0;
      font-size: 14px;
      font-weight: 500;
    }
    .notice-box .ar { direction: rtl; font-weight: 600; }
    .notice-box .en { font-weight: 400; }

    /* footer (already correct) */
    .footer {
      border-top: 2px solid #0b2a4a;
      padding-top: 14px;
      margin-top: 6px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 8px 16px;
      font-size: 13px;
      color: #0b2a4a;
    }
    .footer .contact-icons i { margin-right: 6px; color: #1d6f9c; width: 18px; }
    .footer .cr { font-weight: 600; }
    .footer .sep-dot { color: #b0c4d9; margin: 0 6px; }

    /* print & responsive */
    @media print {
      body { background: white; padding: 0.3in; }
      .job-card { box-shadow: none; border: 1px solid #ccc; }
    }
    @media (max-width: 768px) {
      .info-col { border-right: none; border-bottom: 1px solid #b8c9dd; flex: 1 1 100%; }
      .info-col:last-child { border-bottom: none; }
      .header-main { flex-direction: column; align-items: center; }
      .header-right { text-align: center; margin-top: 6px; }
    }
  </style>
</head>
<body>
<div class="job-card">

  <!-- ========== HEADER (exact match to uploaded image) ========== -->
  <div class="header-main">
    <div class="header-left">
      <div class="logo-icon"><i class="fas fa-car"></i></div>
    </div>
    <div class="header-center">
      <div class="ar-brand">اسپیشل تائش للغاية بالسيارات (ذ.م.م)</div>
      <div class="en-brand">SPECIAL TOUCH CAR CARE W.L.L</div>
    </div>
    <div class="header-right"></div>
  </div>
  <!-- separator lines (two) -->
  <hr class="sep-line">
  <hr class="sep-line" style="margin-top:0;">

  <!-- Title row: JOB ORDER + Arabic + badge below -->
  <div class="title-row">
    <span class="job-en">JOB ORDER</span>
    <span class="job-ar">ملف خدمة</span>
  </div>
  <div class="badge-wrapper">
    <span class="badge-june">JUNE 2026</span>
  </div>

  <!-- ========== CUSTOMER INFO (exact 3 columns) ========== -->
  <div class="info-grid-exact">
    <!-- col 1: Job Order, Date -->
    <div class="info-col">
      <div class="info-row"><span class="label">Job Order:</span><span class="value"></span></div>
      <div class="info-row"><span class="label">Date:</span><span class="value"></span></div>
    </div>
    <!-- col 2: Customer, Car Model, Plate Number -->
    <div class="info-col">
      <div class="info-row"><span class="label">Customer:</span><span class="value"></span></div>
      <div class="info-row"><span class="label">Car Model:</span><span class="value"></span></div>
      <div class="info-row"><span class="label">Plate Number:</span><span class="value"></span></div>
    </div>
    <!-- col 3: Phone Number, SMA -->
    <div class="info-col">
      <div class="info-row"><span class="label">Phone Number:</span><span class="value"></span></div>
      <div class="info-row"><span class="label">SMA:</span><span class="value"></span></div>
    </div>
  </div>

  <!-- ========== SERVICES TABLE (unchanged, correct) ========== -->
  <table class="table-services">
    <thead><tr><th>Service</th><th style="width:110px;">Price</th><th>Remarks</th></tr></thead>
    <tbody>
      <tr><td><span class="service-name">EX+IN POLISH</span> <span class="service-ar">تلميع خارجي و داخلي</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">EX POLISH</span> <span class="service-ar">تلميع خارجي</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">IN POLISH</span> <span class="service-ar">تلميع داخلي</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">POLISH BY PIECES</span> <span class="service-ar">خدمات تلميع فردية</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">GLASS PROTECTION</span> <span class="service-ar">حماية زجاج</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">TINTING</span> <span class="service-ar">مخفي</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">HEAT ISL</span> <span class="service-ar">عازل حرارى</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">PPF</span> <span class="service-ar">حماية</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">ACCESSORIES</span> <span class="service-ar">اكسسوارات</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">PROGRAMMING</span> <span class="service-ar">برمجة</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">ELECTRIQUE JOB</span> <span class="service-ar">كهرباء سيارات</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">UPHOLSTERY</span> <span class="service-ar">تجديد</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr><td><span class="service-name">DIFFERENT SERVICES</span> <span class="service-ar">خدمات متنوعة</span></td><td class="price-col"></td><td class="remarks-col"></td></tr>
      <tr class="total-row"><td colspan="3"><div style="display:flex; justify-content:space-between; align-items:center;"><span style="font-weight:700;">TOTAL</span><span style="font-weight:700; letter-spacing:2px;">______________</span></div></td></tr>
    </tbody>
  </table>

  <!-- ========== BOTTOM: left (vehicles) + right (signatures) ========== -->
  <div class="row g-3">
    <!-- LEFT COLUMN: 4 vehicle boxes in 2x2 grid -->
    <div class="col-lg-6">
      <div class="row g-2">
        <div class="col-6"><div class="vehicle-box"><svg viewBox="0 0 100 60"><rect x="10" y="15" width="80" height="30" rx="6" stroke="currentColor" stroke-width="2" fill="white"/><rect x="25" y="10" width="50" height="10" rx="3" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="30" cy="48" r="8" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="70" cy="48" r="8" stroke="currentColor" stroke-width="2" fill="white"/></svg><div class="v-label">Front</div></div></div>
        <div class="col-6"><div class="vehicle-box"><svg viewBox="0 0 100 60"><rect x="10" y="15" width="80" height="30" rx="6" stroke="currentColor" stroke-width="2" fill="white"/><rect x="15" y="20" width="70" height="18" rx="2" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="30" cy="48" r="8" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="70" cy="48" r="8" stroke="currentColor" stroke-width="2" fill="white"/></svg><div class="v-label">Rear</div></div></div>
        <div class="col-6"><div class="vehicle-box"><svg viewBox="0 0 100 60"><rect x="10" y="5" width="80" height="50" rx="8" stroke="currentColor" stroke-width="2" fill="white"/><rect x="18" y="12" width="64" height="36" rx="4" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="28" cy="22" r="4" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="72" cy="22" r="4" stroke="currentColor" stroke-width="2" fill="white"/></svg><div class="v-label">Top</div></div></div>
        <div class="col-6"><div class="vehicle-box"><svg viewBox="0 0 100 60"><rect x="8" y="12" width="84" height="36" rx="10" stroke="currentColor" stroke-width="2" fill="white"/><rect x="18" y="5" width="64" height="12" rx="4" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="28" cy="50" r="8" stroke="currentColor" stroke-width="2" fill="white"/><circle cx="72" cy="50" r="8" stroke="currentColor" stroke-width="2" fill="white"/></svg><div class="v-label">Side</div></div></div>
      </div>
    </div>

    <!-- RIGHT COLUMN: top row empty boxes, bottom row signatures -->
    <div class="col-lg-6">
      <div class="row g-2">
        <!-- top row: two empty boxes -->
        <div class="col-6"><div class="empty-box"></div></div>
        <div class="col-6"><div class="empty-box"></div></div>
        <!-- bottom row: signature boxes -->
        <div class="col-6"><div class="sig-box"><span class="label">CUSTOMER SIGNATURE</span><span class="line"></span></div></div>
        <div class="col-6"><div class="sig-box"><span class="label">MANAGER SIGNATURE</span><span class="line"></span></div></div>
      </div>
    </div>
  </div>

  <!-- ========== NOTICE (unchanged) ========== -->
  <div class="notice-box">
    <span class="ar">ملحوظة: الرجاء أخذ كامل االغراض الخاصة بك لن المصل غير مسؤول عن اي مستلزمات داخل المركبة.</span>
    <span class="en">Important Notice: Please take all your belongings with you as the store is not responsible for any supplies inside the vehicle. The car is all painted and the shop is not respansibility if painted removed.</span>
  </div>

  <!-- ========== FOOTER (unchanged) ========== -->
  <div class="footer">
    <div><i class="fas fa-map-pin" style="color:#1d6f9c; margin-right:6px;"></i> Special Touch Car Care Qatar</div>
    <div class="contact-icons">
      <i class="fas fa-globe"></i> specialtouch.qa
      <span class="sep-dot">|</span>
      <i class="fas fa-envelope"></i> info@specialtouch.qa
      <span class="sep-dot">|</span>
      <i class="fas fa-phone-alt"></i> +974 1234 5678
    </div>
    <div class="cr"><i class="far fa-registered"></i> CR: 123456</div>
  </div>

</div>
</body>
</html>
