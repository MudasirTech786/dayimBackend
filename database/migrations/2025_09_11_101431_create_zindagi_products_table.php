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
        Schema::create('zindagi_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('dealer')->nullable();
            $table->enum('sold', ['Yes', 'No', 'Reserved'])->default('No');
            $table->string('purchased_by')->nullable();
            $table->string('category')->nullable(); // Apartment / Commercial
            $table->string('dz_type')->nullable(); // Studio / One Bed / Two Bed
            $table->string('subtype')->nullable(); // Elite / Royal / Blue View / Twin Treat
            $table->string('size')->nullable();
            $table->string('floor')->nullable();
            $table->string('number')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zindagi_products');
    }
};
