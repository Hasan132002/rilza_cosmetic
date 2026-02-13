<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Order;

echo "\n╔════════════════════════════════════════════╗\n";
echo "║      ORDERS TABLE - B2B COLUMNS           ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

echo "📊 B2B-Related Columns in Orders Table:\n\n";

$columns = DB::select('DESCRIBE orders');
foreach ($columns as $col) {
    if (stripos($col->Field, 'b2b') !== false ||
        stripos($col->Field, 'purchase') !== false ||
        stripos($col->Field, 'sales_rep') !== false ||
        stripos($col->Field, 'business') !== false) {
        echo "✅ {$col->Field}\n";
        echo "   Type: {$col->Type}\n";
        echo "   Null: {$col->Null}\n";
        echo "   Default: {$col->Default}\n\n";
    }
}

echo "\n📋 Sample Orders (B2B vs B2C):\n";
echo "─────────────────────────────────────────────\n\n";

$orders = Order::select('id', 'order_number', 'customer_name', 'total_amount', 'is_b2b_order', 'purchase_order_number', 'order_status')
    ->limit(10)
    ->get();

if ($orders->isEmpty()) {
    echo "No orders found in database.\n";
} else {
    foreach ($orders as $order) {
        $type = $order->is_b2b_order ? '🏢 B2B' : '👤 B2C';
        $po = $order->purchase_order_number ? "PO: {$order->purchase_order_number}" : 'No PO';

        echo "Order #{$order->id}: {$order->order_number}\n";
        echo "  Type: {$type}\n";
        echo "  Customer: {$order->customer_name}\n";
        echo "  {$po}\n";
        echo "  Total: Rs " . number_format($order->total_amount, 0) . "\n";
        echo "  Status: {$order->order_status}\n\n";
    }
}

echo "\n📊 Statistics:\n";
echo "─────────────────────────────────────────────\n";
$totalOrders = Order::count();
$b2bOrders = Order::where('is_b2b_order', true)->count();
$b2cOrders = Order::where('is_b2b_order', false)->orWhereNull('is_b2b_order')->count();

echo "Total Orders: {$totalOrders}\n";
echo "B2B Orders: {$b2bOrders} 🏢\n";
echo "B2C Orders: {$b2cOrders} 👤\n\n";

if ($totalOrders > 0) {
    $b2bPercent = round(($b2bOrders / $totalOrders) * 100, 1);
    $b2cPercent = round(($b2cOrders / $totalOrders) * 100, 1);
    echo "B2B: {$b2bPercent}%\n";
    echo "B2C: {$b2cPercent}%\n";
}

echo "\n✅ Database structure ready for B2B/B2C tracking!\n\n";
