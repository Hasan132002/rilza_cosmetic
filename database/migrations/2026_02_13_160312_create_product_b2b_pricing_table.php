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
        Schema::create('product_b2b_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('wholesale_price', 10, 2);
            $table->integer('minimum_order_quantity')->default(10);
            // Bulk tier 1
            $table->integer('bulk_tier_1_qty')->nullable();
            $table->decimal('bulk_tier_1_price', 10, 2)->nullable();
            // Bulk tier 2
            $table->integer('bulk_tier_2_qty')->nullable();
            $table->decimal('bulk_tier_2_price', 10, 2)->nullable();
            // Bulk tier 3
            $table->integer('bulk_tier_3_qty')->nullable();
            $table->decimal('bulk_tier_3_price', 10, 2)->nullable();
            $table->boolean('is_available_for_b2b')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_b2b_pricing');
    }
};
