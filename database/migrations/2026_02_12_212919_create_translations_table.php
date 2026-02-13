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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); // e.g., 'messages', 'frontend', 'validation'
            $table->string('key')->index(); // e.g., 'home', 'add_to_cart'
            $table->string('locale', 5)->index(); // e.g., 'en', 'ur'
            $table->text('value'); // The translated text
            $table->timestamps();

            // Unique constraint to prevent duplicate translations
            $table->unique(['group', 'key', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
