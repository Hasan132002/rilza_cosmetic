<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #ec4899;
        }

        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .company-name {
            font-size: 32px;
            font-weight: bold;
            background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .company-tagline {
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 10px;
            color: #666;
            line-height: 1.8;
        }

        .invoice-title {
            font-size: 36px;
            font-weight: bold;
            color: #ec4899;
            margin-bottom: 5px;
        }

        .invoice-details {
            font-size: 11px;
            color: #666;
        }

        .addresses {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .address-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .address-block:first-child {
            margin-right: 15px;
        }

        .address-title {
            font-size: 13px;
            font-weight: bold;
            color: #ec4899;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .address-content {
            font-size: 11px;
            line-height: 1.8;
        }

        .b2b-badge {
            display: inline-block;
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .items-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .items-table thead {
            background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
            color: white;
        }

        .items-table th {
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .items-table tbody tr:hover {
            background: #fce7f3;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals-section {
            width: 100%;
            margin-bottom: 30px;
        }

        .totals-table {
            width: 350px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 12px;
            font-size: 11px;
        }

        .totals-table .label {
            text-align: left;
            color: #666;
        }

        .totals-table .amount {
            text-align: right;
            font-weight: bold;
        }

        .totals-table .subtotal-row {
            border-top: 1px solid #e5e7eb;
        }

        .totals-table .discount-row {
            color: #16a34a;
        }

        .totals-table .tax-row {
            border-top: 1px solid #e5e7eb;
        }

        .totals-table .total-row {
            border-top: 2px solid #ec4899;
            background: #fce7f3;
            font-size: 14px;
        }

        .totals-table .total-row td {
            padding: 12px;
            color: #ec4899;
            font-weight: bold;
        }

        .notes-section {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 4px;
        }

        .notes-title {
            font-size: 12px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
        }

        .notes-content {
            font-size: 10px;
            color: #78350f;
            line-height: 1.8;
        }

        .terms-section {
            border-top: 2px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 30px;
        }

        .terms-title {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .terms-list {
            font-size: 10px;
            color: #666;
            line-height: 2;
            padding-left: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ec4899;
            font-size: 10px;
            color: #666;
        }

        .footer-highlight {
            color: #ec4899;
            font-weight: bold;
        }

        .po-number {
            background: #ede9fe;
            border: 2px dashed #a855f7;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 11px;
        }

        .po-label {
            font-weight: bold;
            color: #7c3aed;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="company-name">Rizla</div>
                <div class="company-tagline">Premium Cosmetics</div>
                <div class="company-info">
                    <strong>Rizla Cosmetics Pvt. Ltd.</strong><br>
                    123 Beauty Boulevard, Karachi<br>
                    Pakistan 75500<br>
                    Phone: +92 300 1234567<br>
                    Email: info@rizla.com<br>
                    GST: RIZLA123456789
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-details">
                    <strong>Invoice #:</strong> {{ $invoice_number }}<br>
                    <strong>Order #:</strong> {{ $order->order_number }}<br>
                    <strong>Date:</strong> {{ $invoice_date }}<br>
                    <strong>Status:</strong> <span style="color: #16a34a;">{{ ucfirst($order->order_status) }}</span>
                </div>
            </div>
        </div>

        <!-- B2B Badge and PO Number -->
        @if($order->is_b2b_order)
        <div style="margin-bottom: 20px;">
            <span class="b2b-badge">BUSINESS ORDER - WHOLESALE PRICING</span>
            @if($order->purchase_order_number)
            <div class="po-number">
                <span class="po-label">Purchase Order:</span> {{ $order->purchase_order_number }}
            </div>
            @endif
        </div>
        @endif

        <!-- Addresses -->
        <div class="addresses">
            <div class="address-block">
                <div class="address-title">Bill To:</div>
                <div class="address-content">
                    <strong>{{ $order->customer_name }}</strong><br>
                    @if($order->user && $order->user->businessProfile)
                        {{ $order->user->businessProfile->company_name }}<br>
                        Tax ID: {{ $order->user->businessProfile->tax_id_number }}<br>
                    @endif
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}
                </div>
            </div>
            <div class="address-block">
                <div class="address-title">Ship To:</div>
                <div class="address-content">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}
                    @if($order->shipping_postal_code)
                        - {{ $order->shipping_postal_code }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Product</th>
                    <th style="width: 15%;" class="text-center">Quantity</th>
                    <th style="width: 17.5%;" class="text-right">Unit Price</th>
                    <th style="width: 17.5%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong><br>
                        <span style="font-size: 9px; color: #666;">SKU: {{ $item->product_sku }}</span>
                        @if($item->variant_name)
                            <br><span style="font-size: 9px; color: #666;">Variant: {{ $item->variant_name }}</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rs {{ number_format($item->price, 2) }}</td>
                    <td class="text-right">Rs {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                <tr class="subtotal-row">
                    <td class="label">Subtotal:</td>
                    <td class="amount">Rs {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr class="discount-row">
                    <td class="label">
                        Discount
                        @if($order->coupon_code)
                            ({{ $order->coupon_code }})
                        @endif:
                    </td>
                    <td class="amount">- Rs {{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="tax-row">
                    <td class="label">GST ({{ number_format($tax_rate, 0) }}%):</td>
                    <td class="amount">Rs {{ number_format($tax_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label">TOTAL AMOUNT:</td>
                    <td class="amount">Rs {{ number_format($total_with_tax, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        @if($order->notes)
        <div class="notes-section">
            <div class="notes-title">Order Notes:</div>
            <div class="notes-content">{{ $order->notes }}</div>
        </div>
        @endif

        <!-- Payment Info -->
        <div class="notes-section" style="background: #dbeafe; border-left-color: #3b82f6;">
            <div class="notes-title" style="color: #1e40af;">Payment Information:</div>
            <div class="notes-content" style="color: #1e3a8a;">
                <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}<br>
                @if($order->is_b2b_order)
                    <strong>Payment Terms:</strong> Net 30 days from invoice date<br>
                @endif
                <strong>Currency:</strong> Pakistani Rupees (PKR)
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="terms-section">
            <div class="terms-title">Terms & Conditions:</div>
            <ul class="terms-list">
                <li>All prices are in Pakistani Rupees (PKR) and include applicable GST.</li>
                @if($order->is_b2b_order)
                    <li>Payment is due within 30 days of invoice date for B2B orders.</li>
                    <li>Wholesale pricing has been applied as per your business agreement.</li>
                @else
                    <li>Payment to be made on delivery for Cash on Delivery orders.</li>
                @endif
                <li>Products are eligible for return within 7 days of delivery in original packaging.</li>
                <li>Please inspect the products upon delivery and report any damages immediately.</li>
                <li>For any queries regarding this invoice, please contact us at info@rizla.com</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p style="margin-top: 10px;">
                This is a computer-generated invoice and does not require a signature.<br>
                <span class="footer-highlight">Rizla Cosmetics</span> - Making Beauty Accessible to Everyone
            </p>
        </div>
    </div>
</body>
</html>
