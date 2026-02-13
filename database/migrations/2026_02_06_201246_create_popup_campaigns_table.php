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
        Schema::create('popup_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['discount', 'newsletter', 'exit_intent', 'announcement'])->default('discount');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('image')->nullable();
            $table->string('coupon_code')->nullable();
            $table->integer('delay_seconds')->default(3); // Show after X seconds
            $table->boolean('show_on_exit')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('display_frequency')->default(1); // 1=every visit, 7=once per week
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popup_campaigns');
    }
};
