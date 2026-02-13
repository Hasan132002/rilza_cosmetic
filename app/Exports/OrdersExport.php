<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Status',
            'Subtotal',
            'Discount',
            'Total Amount',
            'Payment Method',
            'Order Date',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->customer_name,
            $order->customer_email,
            $order->customer_phone,
            ucfirst(str_replace('_', ' ', $order->order_status)),
            number_format($order->subtotal, 2),
            number_format($order->discount_amount, 2),
            number_format($order->total_amount, 2),
            strtoupper($order->payment_method),
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
