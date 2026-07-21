@extends('layouts.app')
@section('page-title', 'Job Order')
@section('page-subtitle', 'Manage service orders')

@section('content')
<!-- Include Bootstrap Icons for the typography and footer -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap');

    .job-card * {
        box-sizing: border-box;
        font-family: 'Montserrat', 'Cairo', sans-serif;
    }

    .job-card {
        max-width: 950px;
        width: 100%;
        margin: 0 auto;
        background: #ffffff;
        padding: 40px;
        border: 1px solid #cbd5e1;
        color: #0E2038;
    }

    /* ========== HEADER SYSTEM (logo left, brand text centered beside it) ========== */
    .header-main {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 18px;
        text-align: center;
        margin-bottom: 5px;
        position: relative;
    }

    .header-logo {
        flex: none;
    }

    .header-logo img {
        display: block;
        width: auto;
        max-width: 130px;
        height: auto;
        max-height: 90px;
        object-fit: contain;
    }

    .header-brand {
        flex: none;
        text-align: center;
    }

    .header-brand .ar-brand {
        font-size: 24px;
        font-weight: 800;
        color: #00204a;
        margin-bottom: 2px;
        font-family: 'Cairo', sans-serif;
        text-align: center
    }

    .header-brand .en-brand {
        font-weight: 700;
        font-size: 16px;
        letter-spacing: 1px;
        color: #3b82f6;
        text-align: center
    }

    /* Horizontal Divider Line matching reference image */
    .header-line-divider {
        width: 100%;
        height: 2px;
        background-color: #3b82f6;
        margin-top: 10px;
        margin-bottom: 25px;
    }

    /* Title Layout */
    .title-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .title-row .job-en {
        font-weight: 800;
        font-size: 34px;
        letter-spacing: 0.5px;
        color: #00204a;
    }

    .title-row .job-ar {
        font-size: 34px;
        font-weight: 800;
        color: #00204a;
        font-family: 'Cairo', sans-serif;
    }

    .badge-wrapper {
        text-align: center;
        margin: 10px 0 25px 0;
    }

    .badge-june {
        background-color: #00204a;
        color: white;
        font-weight: 700;
        font-size: 18px;
        padding: 6px 40px;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    /* ========== CUSTOMER INFO GRID ========== */
    .info-grid-exact {
        border: 1.5px solid #00204a;
        border-radius: 4px;
        display: flex;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .info-col {
        padding: 12px 15px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 10px;
    }

    .info-col-1 {
        flex: 0 0 27%;
        border-right: 1.5px solid #00204a;
    }

    .info-col-2 {
        flex: 0 0 43%;
        border-right: 1.5px solid #00204a;
    }

    .info-col-3 {
        flex: 0 0 30%;
    }

    .info-row {
        display: flex;
        font-size: 13px;
        align-items: baseline;
    }

    .info-row .label {
        font-weight: 700;
        color: #000000;
        margin-right: 6px;
        white-space: nowrap;
    }

    .info-row .value {
        font-weight: 600;
        color: #333;
        flex: 1;
        outline: none;
        border-bottom: 1px dotted #cbd5e1;
        min-height: 18px;
    }

    /* editable inputs styled to look identical to the old contenteditable spans */
    input.value {
        border: none;
        border-bottom: 1px dotted #cbd5e1;
        background: transparent;
        font-weight: 600;
        color: #333;
        font-size: 13px;
        font-family: 'Montserrat', 'Cairo', sans-serif;
        width: 100%;
        padding: 0;
    }

    input.value:focus {
        outline: none;
        border-bottom: 1px solid #3b82f6;
    }

    /* ========== SERVICES TABLE ========== */
    .table-services {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin-bottom: 0;
    }

    .table-services thead th {
        background-color: #00204a;
        color: white;
        font-weight: 700;
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #00204a;
        text-transform: uppercase;
    }

    .table-services tbody td {
        padding: 8px 15px;
        border: 1px solid #cbd5e1;
        vertical-align: middle;
    }

    .service-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        gap: 8px;
    }

    .service-name-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
    }

    .service-name {
        font-weight: 700;
        color: #000000;
        text-align: left;
        font-size: 12px;
        border: none;
        background: transparent;
        width: 100%;
        font-family: 'Montserrat', sans-serif;
    }

    .service-ar {
        font-weight: 700;
        color: #000000;
        text-align: right;
        font-family: 'Cairo', sans-serif;
        font-size: 13px;
        border: none;
        background: transparent;
        width: 100%;
    }

    .service-name:focus, .service-ar:focus {
        outline: none;
        background: #f8fafc;
    }

    .row-delete-btn {
        border: none;
        background: transparent;
        color: #cbd5e1;
        cursor: pointer;
        font-size: 15px;
        padding: 2px 4px;
        line-height: 1;
        flex: none;
    }

    .row-delete-btn:hover {
        color: #dc2626;
    }

    .price-col {
        width: 18%;
        text-align: center;
    }

    .price-col input {
        border: none;
        background: transparent;
        outline: none;
        font-weight: 600;
        text-align: center;
        width: 100%;
        font-family: 'Montserrat', sans-serif;
    }

    .price-col input:focus {
        background: #f8fafc;
    }

    .remarks-col {
        width: 32%;
    }

    .remarks-col input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-family: 'Montserrat', sans-serif;
    }

    .remarks-col input:focus {
        background: #f8fafc;
    }

    .add-row-wrapper {
        text-align: left;
        padding: 8px 4px;
        border: 1px dashed #cbd5e1;
        border-top: none;
    }

    .add-row-btn {
        border: none;
        background: transparent;
        color: #3b82f6;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 8px;
    }

    .add-row-btn:hover {
        color: #00204a;
    }

    .addons-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 22px;
        margin-bottom: 8px;
    }

    .addons-heading .title {
        font-weight: 800;
        font-size: 14px;
        color: #00204a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .total-row td {
        background-color: #00204a !important;
        color: white !important;
        padding: 10px 0;
        border: 1px solid #00204a;
    }

    .total-container {
        display: flex;
        width: 100%;
        align-items: center;
    }

    .total-label-col {
        width: 50%;
    }

    .total-split-col {
        width: 18%;
        text-align: center;
        font-weight: 700;
        font-size: 15px;
    }

    .total-text-col {
        width: 32%;
        text-align: right;
        padding-right: 40px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    /* ========== DIAGRAMS & SIGNATURES ========== */
    .synchronized-bottom-section {
        display: flex;
        width: 100%;
        margin-top: 20px;
        gap: 15px;
    }

    .blueprint-outer-col {
        width: 55%;
    }

    .signatures-outer-col {
        width: 45%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .blueprint-container {
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 8px;
        background: #ffffff;
    }

    .blueprint-container img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }

    .signatures-container {
        display: flex;
        gap: 15px;
        width: 100%;
    }

    .sig-box {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding-top: 10px;
        background: #ffffff;
        position: relative;
    }

    .sig-box .label {
        font-weight: 700;
        color: #000000;
        font-size: 11px;
        letter-spacing: 0.3px;
    }

    .sig-box canvas {
        width: 100%;
        flex: 1;
        touch-action: none;
        cursor: crosshair;
    }

    .sig-clear-btn {
        position: absolute;
        top: 6px;
        right: 8px;
        border: none;
        background: transparent;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: underline;
    }

    .sig-clear-btn:hover {
        color: #dc2626;
    }

    /* ========== NOTICE BOX ========== */
    .notice-box {
        background-color: #e2e8f0;
        border-radius: 12px;
        padding: 15px 25px;
        color: #0f172a;
        text-align: center;
        margin: 20px 0;
    }

    .notice-box .ar {
        direction: rtl;
        font-weight: 700;
        font-size: 14px;
        display: block;
        margin-bottom: 5px;
        font-family: 'Cairo', sans-serif;
    }

    .notice-box .en {
        font-weight: 600;
        font-size: 11px;
        color: #334155;
        display: block;
        line-height: 1.5;
    }

    /* ========== FOOTER ========== */
    .footer {
        padding-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        font-weight: 700;
        color: #00204a;
    }

    .footer-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .footer-item span {
        font-family: 'Montserrat', sans-serif;
    }

    .footer i {
        color: #00204a;
        font-size: 14px;
        background: #e2e8f0;
        padding: 5px;
        border-radius: 4px;
    }

    /* ========== SUBMIT / ACTION BAR ========== */
    .action-bar {
        display: flex;
        justify-content: center;
        margin: 25px 0 10px;
    }

    .save-btn {
        background-color: #00204a;
        color: #fff;
        border: none;
        padding: 12px 40px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .save-btn:hover {
        background-color: #3b82f6;
    }

    .save-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .form-alert {
        max-width: 950px;
        margin: 0 auto 15px;
        padding: 10px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        display: none;
    }

    .form-alert.success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .form-alert.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
</style>

<div id="formAlert" class="form-alert"></div>

<form id="vehicleEntryForm" class="job-card" novalidate>
    @csrf
    <!-- ========== HEADER ========== -->
    <div class="header-main">
        {{-- <div class="header-logo">
            <img src="{{ asset('assets/logo/logo.png') }}" alt="Special Touch Car Care Logo">
        </div> --}}
        <div class="header-brand">
            <div class="ar-brand">اسبيشل تاتش للعناية بالسيارات (ذ.م.م)</div>
            <div class="en-brand">SPECIAL TOUCH CAR CARE W.L.L</div>
        </div>
    </div>

    <!-- Continuous Accent Line -->
    <div class="header-line-divider"></div>

    <!-- Title Layout -->
    <div class="title-row">
        <span class="job-en">JOB ORDER</span>
        <span class="job-ar">ملف خدمة</span>
    </div>

    <div class="badge-wrapper">
        <span class="badge-june">{{ strtoupper(now()->format('F Y')) }}</span>
    </div>

    <!-- ========== CUSTOMER INFO GRID ========== -->
    <div class="info-grid-exact">
        <!-- Column 1 -->
        <div class="info-col info-col-1">
            <div class="info-row">
                <span class="label">Job Order:</span>
                <input type="text" name="job_order_no" class="value" value="{{ $nextJobOrderNo }}" readonly>
            </div>
            <div class="info-row">
                <span class="label">Date :</span>
                <input type="date" name="entry_date" class="value" value="{{ now()->format('Y-m-d') }}" required>
            </div>
        </div>
        <!-- Column 2 -->
        <div class="info-col info-col-2">
            <div class="info-row">
                <span class="label">Customer :</span>
                <input type="text" name="customer_name" class="value" required>
            </div>
            <div class="info-row">
                <span class="label">Car Model:</span>
                <input type="text" name="car_model" class="value">
            </div>
            <div class="info-row">
                <span class="label">Plate Number:</span>
                <input type="text" name="plate_number" class="value">
            </div>
        </div>
        <!-- Column 3 -->
        <div class="info-col info-col-3">
            <div class="info-row">
                <span class="label">Phone Number:</span>
                <input type="text" name="phone_number" class="value">
            </div>
            <div class="info-row">
                <span class="label">SMA:</span>
                <input type="text" name="sma" class="value">
            </div>
        </div>
    </div>

    <!-- ========== SERVICES TABLE (dynamic) ========== -->
    <table class="table-services">
        <thead>
            <tr>
                <th style="width: 50%;">Service</th>
                <th style="width: 18%;">Price</th>
                <th style="width: 32%;">Remarks</th>
            </tr>
        </thead>
        <tbody id="servicesBody">
            <!-- rows injected by JS, seeded with one row below -->
        </tbody>
    </table>
    <div class="add-row-wrapper">
        <button type="button" class="add-row-btn" data-add="service">
            <i class="bi bi-plus-circle-fill"></i> Add Service
        </button>
    </div>

    <!-- ========== ADD-ONS (dynamic) ========== -->
    <div class="addons-heading">
        <span class="title">Add-Ons</span>
        <button type="button" class="add-row-btn" data-add="addon">
            <i class="bi bi-plus-circle-fill"></i> Add Add-On
        </button>
    </div>
    <table class="table-services">
        <tbody id="addonsBody">
            <!-- empty by default, rows injected by JS -->
        </tbody>
    </table>

    <!-- ========== TOTAL ========== -->
    <table class="table-services" style="margin-top: 0;">
        <tbody>
            <tr class="total-row">
                <td colspan="3">
                    <div class="total-container">
                        <div class="total-label-col"></div>
                        <div class="total-split-col">:</div>
                        <div class="total-text-col">TOTAL&nbsp; <span id="grandTotal">0.00</span></div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ========== BOTTOM DIAGRAMS & SIGNATURES ========== -->
    <div class="synchronized-bottom-section">
        <div class="blueprint-outer-col">
            <div class="blueprint-container">
                <img src="{{ asset('assets/vehicle/inspection-diagram.jpeg') }}" alt="Vehicle inspection diagram">
            </div>
        </div>

        <div class="signatures-outer-col">
            <div class="signatures-container">
                <div class="sig-box">
                    <button type="button" class="sig-clear-btn" data-clear="customer">Clear</button>
                    <span class="label">CUSTOMER SIGNATURE</span>
                    <canvas id="customerSignaturePad"></canvas>
                    <input type="hidden" name="customer_signature" id="customerSignatureInput">
                </div>
                <div class="sig-box">
                    <button type="button" class="sig-clear-btn" data-clear="manager">Clear</button>
                    <span class="label">MANAGER SIGNATURE</span>
                    <canvas id="managerSignaturePad"></canvas>
                    <input type="hidden" name="manager_signature" id="managerSignatureInput">
                </div>
            </div>
        </div>
    </div>

    <!-- ========== SAVE / SUBMIT ========== -->
    <div class="action-bar">
        <button type="submit" class="save-btn" id="submitBtn">
            <i class="bi bi-save2-fill"></i> Save &amp; Generate PDF
        </button>
    </div>

    <!-- ========== NOTICE BOX ========== -->
    <div class="notice-box">
        <span class="ar">ملحوظة: الرجاء أخذ كامل الأغراض الخاصة بك لأن المحل غير مسؤول عن أي مستلزمات داخل المركبة.</span>
        <span class="en">Important Notice: Please take all your belongings with you as the store is not responsible for any supplies inside the vehicle.<br>The car is all painted and the shop is not responsibility if painted removed.</span>
    </div>

    <!-- ========== FOOTER ========== -->
    <div class="footer">
        <div class="footer-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Building, 423, Street 340, Zone 56. Doha, Qatar</span>
        </div>

        <div class="footer-item">
            <i class="bi bi-globe"></i>
            <span>www.zpecial-touch.com</span>
        </div>

        <div class="footer-item">
            <i class="bi bi-envelope-fill"></i>
            <span>info@special-touch.com</span>
        </div>

        <div class="footer-item">
            <i class="bi bi-telephone-fill"></i>
            <span>+974 7777 1065</span>
        </div>

        <div class="footer-item">
            <i class="bi bi-hash"></i>
            <span>204895</span>
        </div>
    </div>
</form>

<!-- Row template for a service / add-on line item -->
<template id="serviceRowTemplate">
    <tr class="service-row">
        <td>
            <div class="service-container">
                <div class="service-name-group">
                    <input type="text" class="service-name" placeholder="Service name (English)" data-field="name_en">
                    <input type="text" class="service-ar" placeholder="اسم الخدمة (عربي)" data-field="name_ar" dir="rtl">
                </div>
                <button type="button" class="row-delete-btn" title="Remove row">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            </div>
        </td>
        <td class="price-col">
            <input type="number" step="0.01" min="0" placeholder="0.00" data-field="price">
        </td>
        <td class="remarks-col">
            <input type="text" placeholder="Remarks" data-field="remarks">
        </td>
    </tr>
</template>

<!-- signature_pad — lightweight canvas signature capture, no jQuery required -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
(function () {
    'use strict';

    const STORE_URL = "{{ route('vehicle-entries.store') }}";
    const CSRF_TOKEN = document.querySelector('input[name="_token"]').value;

    // ---------- Dynamic rows (services + add-ons) ----------
    const rowTemplate = document.getElementById('serviceRowTemplate');
    const servicesBody = document.getElementById('servicesBody');
    const addonsBody = document.getElementById('addonsBody');
    const grandTotalEl = document.getElementById('grandTotal');

    function addRow(targetBody, prefill) {
        const clone = rowTemplate.content.cloneNode(true);
        const row = clone.querySelector('.service-row');

        if (prefill) {
            row.querySelector('[data-field="name_en"]').value = prefill.name_en || '';
            row.querySelector('[data-field="name_ar"]').value = prefill.name_ar || '';
            row.querySelector('[data-field="price"]').value = prefill.price || '';
            row.querySelector('[data-field="remarks"]').value = prefill.remarks || '';
        }

        row.querySelectorAll('input[data-field="price"]').forEach(el => {
            el.addEventListener('input', recalcTotal);
        });
        row.querySelector('.row-delete-btn').addEventListener('click', function () {
            row.remove();
            recalcTotal();
        });

        targetBody.appendChild(row);
        recalcTotal();
        return row;
    }

    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('#servicesBody input[data-field="price"], #addonsBody input[data-field="price"]')
            .forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) total += val;
            });
        grandTotalEl.textContent = total.toFixed(2);
    }

    document.querySelectorAll('[data-add]').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = btn.dataset.add === 'service' ? servicesBody : addonsBody;
            addRow(target);
        });
    });

    // Seed the form with one starter service row, matching the original layout.
    addRow(servicesBody, { name_en: 'EX+IN POLISH', name_ar: 'تلميع خارجي و داخلي', price: '', remarks: '' });

    // ---------- Signature pads ----------
    function initSignaturePad(canvasId, hiddenInputId) {
        const canvas = document.getElementById(canvasId);
        const hiddenInput = document.getElementById(hiddenInputId);

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const data = pad.toData();
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            pad.clear();
            if (data && data.length) pad.fromData(data);
        }

        const pad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,0)',
            penColor: '#00204a',
        });

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        pad.addEventListener('endStroke', function () {
            hiddenInput.value = pad.isEmpty() ? '' : pad.toDataURL('image/png');
        });

        return pad;
    }

    const customerPad = initSignaturePad('customerSignaturePad', 'customerSignatureInput');
    const managerPad = initSignaturePad('managerSignaturePad', 'managerSignatureInput');

    document.querySelectorAll('[data-clear]').forEach(btn => {
        btn.addEventListener('click', function () {
            if (btn.dataset.clear === 'customer') {
                customerPad.clear();
                document.getElementById('customerSignatureInput').value = '';
            } else {
                managerPad.clear();
                document.getElementById('managerSignatureInput').value = '';
            }
        });
    });

    // ---------- Collect + submit via AJAX ----------
    function collectRows(body) {
        return Array.from(body.querySelectorAll('.service-row')).map(row => ({
            name_en: row.querySelector('[data-field="name_en"]').value.trim(),
            name_ar: row.querySelector('[data-field="name_ar"]').value.trim(),
            price: row.querySelector('[data-field="price"]').value || 0,
            remarks: row.querySelector('[data-field="remarks"]').value.trim(),
        })).filter(r => r.name_en !== '' || r.price !== 0);
    }

    function showAlert(type, message) {
        const alertEl = document.getElementById('formAlert');
        alertEl.className = 'form-alert ' + type;
        alertEl.textContent = message;
        alertEl.style.display = 'block';
        alertEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    const form = document.getElementById('vehicleEntryForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Force endStroke sync in case the last stroke handler hasn't fired yet.
        // Both signatures are optional — only sync whatever was actually drawn.
        document.getElementById('customerSignatureInput').value = customerPad.isEmpty() ? '' : customerPad.toDataURL('image/png');
        document.getElementById('managerSignatureInput').value = managerPad.isEmpty() ? '' : managerPad.toDataURL('image/png');

        const payload = {
            job_order_no: form.job_order_no.value,
            entry_date: form.entry_date.value,
            customer_name: form.customer_name.value,
            phone_number: form.phone_number.value,
            car_model: form.car_model.value,
            plate_number: form.plate_number.value,
            sma: form.sma.value,
            services: collectRows(servicesBody),
            addons: collectRows(addonsBody),
            customer_signature: document.getElementById('customerSignatureInput').value,
            manager_signature: document.getElementById('managerSignatureInput').value,
        };

        if (payload.services.length === 0) {
            showAlert('error', 'Add at least one service row before submitting.');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';

        try {
            const response = await fetch(STORE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok) {
                const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Something went wrong.');
                showAlert('error', firstError);
                return;
            }

            showAlert('success', data.message + ' Downloading PDF...');

            // Force a file download (no new tab) instead of streaming inline.
            const downloadLink = document.createElement('a');
            downloadLink.href = data.pdf_url;
            downloadLink.setAttribute('download', '');
            document.body.appendChild(downloadLink);
            downloadLink.click();
            downloadLink.remove();

            // Give the download a moment to start, then refresh the page so the
            // form comes back empty with a fresh job order number.
            setTimeout(function () {
                window.location.reload();
            }, 1200);
        } catch (err) {
            showAlert('error', 'Network error — please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save2-fill"></i> Save &amp; Generate PDF';
        }
    });
})();
</script>
@endsection
