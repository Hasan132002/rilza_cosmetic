<x-mail::message>
# Order Confirmation

Hi {{ $order->customer_name }},

Thank you for your order! We've received your order and will process it soon.

**Order Number:** {{ $order->order_number }}
**Order Date:** {{ $order->created_at->format('F d, Y') }}
**Total Amount:** PKR {{ number_format($order->total_amount, 2) }}

## Order Details

@foreach($order->items as $item)
- {{ $item->product_name }} @if($item->variant_name)({{ $item->variant_name }})@endif x {{ $item->quantity }} - PKR {{ number_format($item->subtotal, 2) }}
@endforeach

---

**Subtotal:** PKR {{ number_format($order->subtotal, 2) }}
@if($order->discount_amount > 0)
**Discount:** -PKR {{ number_format($order->discount_amount, 2) }}
@endif
**Total:** PKR {{ number_format($order->total_amount, 2) }}

## Shipping Address

{{ $order->shipping_address }}
{{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif

<x-mail::button :url="$orderUrl">
View Order
</x-mail::button>

We'll send you another email when your order ships.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
