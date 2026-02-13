<x-mail::message>
# Order Status Update

Hi {{ $order->customer_name }},

Your order status has been updated!

**Order Number:** {{ $order->order_number }}
**Previous Status:** {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}
**Current Status:** {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}

@if($order->tracking_number)
**Tracking Number:** {{ $order->tracking_number }}
@endif

@if($order->order_status === 'delivered')
Your order has been delivered! We hope you love your products.
@elseif($order->order_status === 'shipped')
Your order is on its way! You should receive it soon.
@elseif($order->order_status === 'processing')
We're preparing your order for shipment.
@elseif($order->order_status === 'cancelled')
Your order has been cancelled. If you have any questions, please contact us.
@endif

<x-mail::button :url="$orderUrl">
View Order Details
</x-mail::button>

If you have any questions about your order, feel free to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
