@extends('emails.layout')

@section('content')
<h2>⚠️ Low Stock Alert</h2>

<p>Hi Admin,</p>

<p>The following products are running low on stock and need your attention:</p>

<div style="background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 20px; margin: 20px 0; border-radius: 4px;">
    @foreach($products as $product)
    <div style="margin-bottom: 15px; padding-bottom: 15px; @if(!$loop->last) border-bottom: 1px solid #fecaca; @endif">
        <strong style="color: #1f2937;">{{ $product->name }}</strong><br>
        <span style="color: #dc2626; font-weight: bold;">Stock: {{ $product->stock_quantity }} units</span><br>
        <span style="color: #6b7280; font-size: 14px;">SKU: {{ $product->sku }}</span>
    </div>
    @endforeach
</div>

<p>Please restock these products to avoid going out of stock.</p>

<div style="text-align: center;">
    <a href="{{ route('admin.products.index') }}" class="button">
        Manage Inventory
    </a>
</div>

<p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
    This is an automated alert from your Rizla Cosmetics Admin Panel.
</p>
@endsection
