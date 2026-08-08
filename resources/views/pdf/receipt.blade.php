<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', 'DejaVu Sans', sans-serif;
            font-size: 9px;
            color: #1f2937;
            line-height: 1.45;
            background: #ffffff;
            width: 150mm;
        }

        .page {
            padding: 10mm;
        }

        /* ── HEADER ── */
        table.hdr {
            width: 100%;
            border-collapse: collapse;
        }

        table.hdr td {
            vertical-align: middle;
        }

        .brand-cell {
            width: 92mm;
        }

        table.brand {
            border-collapse: collapse;
        }

        table.brand td {
            vertical-align: middle;
        }

        .logo-wrap img {
            height: 10mm;
            width: auto;
        }

        .logo-pad {
            padding-right: 3mm;
        }

        .company-name {
            font-size: 13px;
            font-weight: bold;
            color: #1d2d7a;
            letter-spacing: 0.5px;
        }

        .company-sub {
            font-size: 7px;
            color: #6b7280;
            line-height: 1.55;
        }

        .doc-cell {
            text-align: right;
        }

        .doc-title {
            font-size: 22px;
            font-weight: bold;
            color: #f97316;
            letter-spacing: 4px;
        }

        .doc-sub {
            font-size: 7px;
            color: #9a3412;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 0.5mm;
        }

        .hdr-divider {
            height: 2mm;
            background: linear-gradient(90deg, #1d2d7a 0%, #3b5bdb 55%, #f97316 100%);
            margin-top: 4mm;
        }

        /* ── BILL TO / META ── */
        table.meta {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4mm;
        }

        table.meta > tr > td {
            vertical-align: top;
        }

        .billto-cell {
            width: 62mm;
        }

        .box-label {
            font-size: 7px;
            font-weight: bold;
            color: #3b5bdb;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.5mm;
        }

        .buyer-name {
            font-size: 10px;
            font-weight: bold;
            color: #111827;
        }

        .buyer-line {
            font-size: 8.5px;
            color: #4b5563;
            margin-top: 0.5mm;
        }

        table.kv {
            width: 100%;
            border-collapse: collapse;
        }

        table.kv td {
            padding: 0.7mm 0;
            font-size: 8.5px;
            vertical-align: top;
        }

        table.kv td.lbl {
            color: #6b7280;
            width: 32mm;
        }

        table.kv td.val {
            font-weight: bold;
            text-align: right;
            color: #111827;
        }

        .status-paid {
            color: #059669;
        }

        /* ── ITEMS TABLE ── */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4mm;
        }

        table.items th {
            background: #1d2d7a;
            color: #ffffff;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1.8mm 2mm;
            text-align: left;
            border: 0.3mm solid #1d2d7a;
        }

        table.items th.no {
            width: 8mm;
        }

        table.items th.item {
            width: 32mm;
        }

        table.items th.amt {
            text-align: right;
            width: 34mm;
        }

        table.items td {
            padding: 1.8mm 2mm;
            border: 0.3mm solid #d1d5db;
            font-size: 8.5px;
            vertical-align: top;
        }

        table.items td.no {
            color: #6b7280;
        }

        table.items td.amt {
            text-align: right;
            font-weight: bold;
            color: #111827;
            white-space: nowrap;
        }

        .item-title {
            font-weight: bold;
            color: #111827;
            font-size: 9.5px;
        }

        .item-line {
            color: #4b5563;
            margin-top: 0.5mm;
        }

        /* ── TOTALS ── */
        table.totals {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3mm;
        }

        .totals-spacer {
            width: 55%;
        }

        .totals-box {
            width: 62mm;
        }

        table.kv2 {
            width: 100%;
            border-collapse: collapse;
        }

        table.kv2 td {
            padding: 1.4mm 2mm;
            font-size: 9px;
            vertical-align: top;
        }

        table.kv2 td.tl {
            color: #374151;
        }

        table.kv2 td.tv {
            text-align: right;
            font-weight: bold;
            color: #111827;
        }

        table.kv2 tr.grand td {
            background: #f97316;
            color: #ffffff;
        }

        table.kv2 tr.grand td.tv {
            color: #ffffff;
            font-size: 11.5px;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 5mm;
            border-top: 0.8mm solid #1d2d7a;
            padding-top: 2.5mm;
            text-align: center;
        }

        .foot-brand {
            font-size: 10px;
            font-weight: bold;
            color: #1d2d7a;
            letter-spacing: 0.5px;
        }

        .foot-line {
            font-size: 8px;
            color: #6b7280;
            margin-top: 0.5mm;
        }

        .foot-note {
            font-size: 7.5px;
            color: #9ca3af;
            margin-top: 1mm;
        }
    </style>
</head>
<body>
    @php
        $logoData = '';
        foreach (['images/logo-receipt.jpg', 'images/logo.png'] as $logoFile) {
            $full = \App\Services\ReceiptService::resolvePublicFile($logoFile);
            if ($full) {
                $ext = pathinfo($full, PATHINFO_EXTENSION);
                $mime = $ext === 'png' ? 'image/png' : 'image/jpeg';
                $logoData = "data:{$mime};base64," . base64_encode(file_get_contents($full));
                break;
            }
        }
        $amount = $payment->formatted_amount;
    @endphp

    <div class="page">

        {{-- ═══════════ HEADER ═══════════ --}}
        <table class="hdr">
            <tr>
                <td class="brand-cell">
                    <table class="brand">
                        <tr>
                            @if($logoData)
                                <td class="logo-pad"><div class="logo-wrap"><img src="{{ $logoData }}" alt="{{ config('bfamily.company.name') }}"></div></td>
                            @endif
                            <td>
                                <div class="company-name">{{ config('bfamily.company.name') }}</div>
                                <div class="company-sub">{{ config('bfamily.company.address') }}</div>
                                <div class="company-sub">{{ config('bfamily.company.phone') }} &nbsp;|&nbsp; {{ config('bfamily.company.email') }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="doc-cell">
                    <div class="doc-title">INVOICE</div>
                    <div class="doc-sub">Official Payment Receipt</div>
                </td>
            </tr>
        </table>

        <div class="hdr-divider"></div>

        {{-- ═══════════ BILL TO / META ═══════════ --}}
        <table class="meta">
            <tr>
                <td class="billto-cell">
                    <div class="box-label">Billed To</div>
                    <div class="buyer-name">{{ $payment->buyer_name }}</div>
                    @if($payment->buyer_email)
                        <div class="buyer-line">{{ $payment->buyer_email }}</div>
                    @endif
                    @if($payment->buyer_phone)
                        <div class="buyer-line">{{ $payment->buyer_phone }}</div>
                    @endif
                </td>
                <td>
                    <table class="kv">
                        <tr>
                            <td class="lbl">Invoice No.</td>
                            <td class="val">{{ $receipt->receipt_number }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Payment Ref</td>
                            <td class="val">{{ $payment->reference }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Date &amp; Time</td>
                            <td class="val">{{ $receipt->generated_at->format('d M Y') }} &nbsp;|&nbsp; {{ $receipt->generated_at->format('h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Payment Method</td>
                            <td class="val">{{ \App\Services\ReceiptService::paymentMethodLabel($payment->payment_method) }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Status</td>
                            <td class="val status-paid">PAID</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- ═══════════ ITEMS ═══════════ --}}
        <table class="items">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="item">Item</th>
                    <th>Details</th>
                    <th class="amt">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no">1</td>
                    <td>Property<br>Purchase</td>
                    <td>
                        <div class="item-title">{{ $payment->property->title ?? 'Property' }}</div>
                        @if($payment->property && $payment->property->location)
                            <div class="item-line"><b>Location:</b> {{ $payment->property->location }}</div>
                        @endif
                        @if($payment->property && $payment->property->category)
                            <div class="item-line"><b>Category:</b> {{ ucfirst($payment->property->category) }}</div>
                        @endif
                        <div class="item-line"><b>Sale Type:</b> {{ ucfirst($payment->type) }}</div>
                        @if($payment->installment_number && $payment->total_installments)
                            <div class="item-line"><b>Installment:</b> {{ $payment->installment_number }} of {{ $payment->total_installments }}</div>
                        @endif
                    </td>
                    <td class="amt">{{ $amount }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ═══════════ TOTALS ═══════════ --}}
        <table class="totals">
            <tr>
                <td class="totals-spacer"></td>
                <td class="totals-box">
                    <table class="kv2">
                        <tr>
                            <td class="tl">Total Amount</td>
                            <td class="tv">{{ $amount }}</td>
                        </tr>
                        <tr class="grand">
                            <td class="tl">Amount Paid</td>
                            <td class="tv">{{ $amount }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- ═══════════ FOOTER ═══════════ --}}
        <div class="footer">
            <div class="foot-brand">{{ config('bfamily.company.name') }}</div>
            <div class="foot-line">Thank you for your business &mdash; this is an official payment receipt.</div>
            <div class="foot-line">Keep this receipt for your records.</div>
            <div class="foot-note">{{ config('bfamily.company.name') }} &middot; {{ config('bfamily.company.phone') }}</div>
        </div>

    </div>
</body>
</html>
