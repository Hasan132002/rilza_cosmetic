<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_b2b_order')->default(false)->after('user_id');
            $table->string('purchase_order_number')->nullable()->after('is_b2b_order');
            $table->decimal('business_discount_percentage', 5, 2)->nullable();
            $table->foreignId('sales_rep_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['is_b2b_order', 'purchase_order_number', 'business_discount_percentage', 'sales_rep_id']);
        });
    }
};
