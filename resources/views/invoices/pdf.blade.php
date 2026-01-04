<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceNumber }}</title>
    <style>
        @page {
            margin: 80px 50px 80px 50px;
        }

        /* Global styles - Tailwind-inspired slate palette */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 8pt;
            color: #1e293b; /* slate-800 */
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        h1, h2, h3 {
            font-weight: 600;
            color: #0f172a; /* slate-900 */
            margin: 0;
        }

        /* Header and Footer */
        header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            border-bottom: 2px solid #e2e8f0; /* slate-200 */
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 9pt;
            font-style: italic;
            color: #64748b; /* slate-500 */
            border-top: 1px solid #e2e8f0; /* slate-200 */
        }

        .page-number:before {
            content: "Page " counter(page);
        }

        .logo {
            width: 185px;
            height: auto;
        }

        /* Addresses Section */
        .addresses {
            margin-top: 8px;
            margin-bottom: 8px;
            background-color: #f8fafc; /* slate-50 */
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #e2e8f0; /* slate-200 */
        }

        .from-address {
            width: 48%;
            float: left;
            padding-right: 8px;
        }

        .to-address {
            width: 48%;
            float: right;
            padding-left: 8px;
            border-left: 2px solid #cbd5e1; /* slate-300 */
        }

        .address-label {
            font-weight: 700;
            font-size: 9pt;
            margin-bottom: 3px;
            color: #334155; /* slate-700 */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .address-line {
            margin-bottom: 2px;
            font-size: 8pt;
            color: #475569; /* slate-600 */
        }

        .clear {
            clear: both;
        }

        /* Wire Transfer Section */
        .wire-transfer {
            margin-top: 8px;
            margin-bottom: 8px;
            font-size: 8pt;
            background-color: #f1f5f9; /* slate-100 */
            padding: 6px 10px;
            border-left: 3px solid #64748b; /* slate-500 */
            color: #334155; /* slate-700 */
        }

        .wire-transfer-line {
            margin-bottom: 1px;
        }

        /* Invoice Header */
        .invoice-header {
            text-align: center;
            font-size: 14pt;
            font-weight: 700;
            margin: 10px 0 10px 0;
            color: #0f172a; /* slate-900 */
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 6px;
            background: linear-gradient(to right, #f8fafc, #f1f5f9, #f8fafc); /* slate gradient */
            border-top: 2px solid #cbd5e1; /* slate-300 */
            border-bottom: 2px solid #cbd5e1; /* slate-300 */
        }

        /* Invoice Details */
        .invoice-details {
            margin-bottom: 15px;
            font-size: 8.5pt;
            padding: 6px 10px;
            background-color: #f8fafc; /* slate-50 */
            border-radius: 4px;
            border: 1px solid #e2e8f0; /* slate-200 */
        }

        .invoice-details-line {
            margin-bottom: 2px;
            color: #334155; /* slate-700 */
        }

        .invoice-details-line strong {
            color: #1e293b; /* slate-800 */
            font-weight: 600;
        }

        /* Jobs Table Wrapper */
        .jobs-table-wrapper {
            margin-bottom: 15px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9pt;
            border: 1px solid #cbd5e1; /* slate-300 */
        }

        table thead {
            background-color: #e2e8f0; /* slate-200 */
        }

        table th {
            border: 1px solid #94a3b8; /* slate-400 */
            padding: 10px 6px;
            text-align: center;
            font-weight: 600;
            color: #0f172a; /* slate-900 */
            font-size: 9.5pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table td {
            border: 1px solid #cbd5e1; /* slate-300 */
            padding: 8px 6px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            color: #334155; /* slate-700 */
            background-color: #ffffff;
        }

        table tbody tr:nth-child(even) td {
            background-color: #f8fafc; /* slate-50 */
        }

        table tbody tr {
            page-break-inside: avoid;
        }

        /* Text Alignment */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* Totals Section */
        .totals-section {
            margin-top: 20px;
            page-break-inside: avoid;
            page-break-before: auto;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            page-break-inside: avoid;
            border: 1px solid #cbd5e1; /* slate-300 */
        }

        .totals-table td {
            border: 1px solid #cbd5e1; /* slate-300 */
            padding: 10px 12px;
            background-color: #f8fafc; /* slate-50 */
        }

        .totals-table .label-cell {
            width: 75%;
            text-align: right;
            font-weight: normal;
            color: #334155; /* slate-700 */
        }

        .totals-table .amount-cell {
            width: 25%;
            text-align: right;
            color: #334155; /* slate-700 */
            font-weight: normal;
        }

        .totals-table .total-row {
            font-weight: normal;
            font-size: 11pt;
            background-color: #f1f5f9; /* slate-100 */
        }

        .totals-table .total-row .label-cell {
            color: #1e293b; /* slate-800 */
            font-weight: normal;
        }

        .totals-table .total-row .amount-cell {
            color: #1e293b; /* slate-800 */
            font-weight: normal;
        }

        .vat-explanation {
            font-size: 8.5pt;
            line-height: 1.4;
            text-align: justify;
            color: #1e293b; /* slate-800 */
            font-weight: 600;
        }

        /* Utility Classes */
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <footer>
        <div class="page-number"></div>
    </footer>

    <main>
        <!-- Logo (only on first page) -->
        <div style="margin-bottom: 30px;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo1.png'))) }}" alt="Fintrasc Logo" class="logo">
        </div>

        <!-- Addresses Section -->
        <div class="addresses">
            <div class="from-address">
                <div class="address-label">From:</div>
                <div class="address-line">FINTRASC LTD</div>
                <div class="address-line">Maria Louisa Blvd 45</div>
                <div class="address-line">1202 Sofia</div>
                <div class="address-line">+359(0)8 998 624 65</div>
                <div class="address-line">E-mail: contact@fintrasc.be</div>
                <div class="address-line">VAT: BG204137289</div>
            </div>
            <div class="to-address">
                <div class="address-label">To:</div>
                <div class="address-line">{{ $client->client_name }}</div>
                <div class="address-line">{{ $client->client_address }}</div>
                @if($client->postal_code || $client->city)
                <div class="address-line">{{ $client->postal_code }} {{ $client->city }}</div>
                @endif
                @if($client->country)
                <div class="address-line">{{ $client->country }}</div>
                @endif
                @if($client->invoice_email)
                <div class="address-line">{{ $client->invoice_email }}</div>
                @endif
                @if($client->vat_number)
                <div class="address-line">VAT: {{ $client->vat_number }}</div>
                @endif
            </div>
            <div class="clear"></div>
        </div>

        <!-- Wire Transfer Information -->
        <div class="wire-transfer">
            <div class="wire-transfer-line">Wire transfer:</div>
            <div class="wire-transfer-line">KBC BANK</div>
            <div class="wire-transfer-line">IBAN BE15 7360 3494 5730</div>
            <div class="wire-transfer-line">BIC KREDBEBB</div>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">INVOICE</div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="invoice-details-line"><strong>Invoice date:</strong> {{ now()->format('d-m-Y') }}</div>
            <div class="invoice-details-line"><strong>Invoice number:</strong> {{ $invoiceNumber }}</div>
            @if($extraInfo)
            <div class="invoice-details-line"><strong>Extra info/PRE-INVOICE NR:</strong> {{ $extraInfo }}</div>
            @endif
        </div>

        <!-- Translation Jobs Table -->
        <div class="jobs-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">PO number</th>
                        <th style="width: 10%;">Service</th>
                        <th style="width: 30%;">Job title</th>
                        <th style="width: 12%;">Completed</th>
                        <th style="width: 8%;">Unit</th>
                        <th style="width: 8%;">Quantity</th>
                        <th style="width: 8%;">Price</th>
                        <th style="width: 9%;">Job total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($translationJobs as $job)
                    <tr>
                        <td class="text-center">{{ $job->po_number }}</td>
                        <td class="text-center">{{ $job->service }}</td>
                        <td class="text-left">{{ $job->title }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($job->deadline)->format('d-m-Y') }}</td>
                        <td class="text-center">words</td>
                        <td class="text-center">{{ number_format($job->quantity, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($job->price, 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($job->total_price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals Section -->
        <div class="totals-section no-break">
            <table class="totals-table">
                <tr>
                    <td class="label-cell">SUBTOTAL JOBS (in EUR):</td>
                    <td class="amount-cell">{{ number_format($invoiceNet, 2, ',', '.') }}</td>
                </tr>
                @if($invoiceVat > 0)
                <tr>
                    <td class="label-cell">VAT / TVA / BTW (in EUR):</td>
                    <td class="amount-cell">{{ number_format($invoiceVat, 2, ',', '.') }}</td>
                </tr>
                @else
                <tr>
                    <td class="label-cell vat-explanation">
                        VAT: Service not subject to Bulgarian VAT, Place of the service with the customer,
                        the recipient of the service, according to article 44 of the EU Directive 2006/112/EC.
                        Reverse charge, VAT to be accounted for by the customer - DEFERMENT OF VAT-
                    </td>
                    <td class="amount-cell">0</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td class="label-cell">TOTAL INVOICE (in EUR):</td>
                    <td class="amount-cell">{{ number_format($invoiceTotal, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>
