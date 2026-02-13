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
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #ec4899;
        }

        .company-info h1 {
            font-size: 32px;
            color: #ec4899;
            margin-bottom: 5px;
        }

        .company-info p {
            color: #666;
            margin: 2px 0;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-info p {
            margin: 5px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .details-box {
            width: 48%;
        }

        .details-box h3 {
            font-size: 16px;
            color: #ec4899;
            margin-bottom: 10px;
            border-bottom: 2px solid #fce7f3;
            padding-bottom: 5px;
        }

        .details-box p {
            margin: 5px 0;
            color: #666;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .items-table tbody tr:hover {
            background: #fef3f8;
        }

        .text-right {
            text-align: right;
        }

        .totals-section {
            margin-left: auto;
            width: 300px;
            margin-bottom: 40px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-row.total {
            font-size: 18px;
            font-weight: bold;
            color: #ec4899;
            border-top: 3px solid #ec4899;
            border-bottom: 3px solid #ec4899;
            padding: 15px 0;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 60px;
            padding-top: 20px;
            border-top: 2px solid #f3f4f6;
            color: #666;
        }

        .footer p {
            margin: 5px 0;
        }

        .notes {
            background: #fef3f8;
            padding: 15px;
            border-left: 4px solid #ec4899;
            margin-bottom: 30px;
        }

        .notes h4 {
            color: #ec4899;
            margin-bottom: 8px;
        }

        @media print {
            body {
                padding: 0;
            }

            .invoice-container {
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .print-button:hover {
            background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">Print Invoice</button>

    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>Rizla Cosmetics</h1>
                <p>Premium Beauty & Skincare Products</p>
                <p>Email: info@rizlacosmetics.com</p>
                <p>Phone: +92-XXX-XXXXXXX</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>Invoice Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                @php
                    $statusClass = match($order->order_status) {
                        'pending' => 'status-pending',
                        'confirmed', 'packed', 'shipped', 'out_for_delivery' => 'status-confirmed',
                        'delivered' => 'status-delivered',
                        'cancelled' => 'status-cancelled',
                        default => 'status-pending',
                    };
                @endphp
                <span class="status-badge {{ $statusClass }}">
                    {{ strtoupper(str_replace('_', ' ', $order->order_status)) }}
                </span>
            </div>
        </div>

        <!-- Customer & Shipping Details -->
        <div class="details-section">
            <div class="details-box">
                <h3>Bill To:</h3>
                <p><strong>{{ $order->customer_name }}</strong></p>
                <p>{{ $order->customer_email }}</p>
                <p>{{ $order->customer_phone }}</p>
            </div>
            <div class="details-box">
                <h3>Ship To:</h3>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}</p>
                @if($order->tracking_number)
                <p><strong>Tracking:</strong> {{ $order->tracking_number }}</p>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>SKU</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->variant_name)
                        <br><small style="color: #ec4899;">{{ $item->variant_name }}</small>
                        @endif
                    </td>
                    <td>{{ $item->product_sku }}</td>
                    <td class="text-right">PKR {{ number_format($item->price, 2) }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right"><strong>PKR {{ number_format($item->subtotal, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>PKR {{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="totals-row">
                <span>Discount:</span>
                <span style="color: #059669;">-PKR {{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="totals-row">
                <span>Shipping:</span>
                <span style="color: #059669;">FREE</span>
            </div>
            <div class="totals-row total">
                <span>TOTAL:</span>
                <span>PKR {{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div style="text-align: right; margin-top: 10px; color: #666;">
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong> {{ strtoupper($order->payment_status) }}</p>
            </div>
        </div>

        <!-- Notes -->
        @if($order->notes)
        <div class="notes">
            <h4>Order Notes:</h4>
            <p>{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for shopping with Rizla Cosmetics!</strong></p>
            <p>For any queries, please contact us at info@rizlacosmetics.com</p>
            <p style="font-size: 12px; margin-top: 15px; color: #999;">
                This is a computer-generated invoice and does not require a signature.
            </p>
        </div>
    </div>

    <script>
        // Auto-print on load (optional - remove if not needed)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
