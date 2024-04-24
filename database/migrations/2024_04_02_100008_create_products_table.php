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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('form_number');
            $table->string('floor');
            $table->string('category');
            $table->decimal('sales_value', 10, 2); // Assuming sales_value is a decimal with precision 10 and scale 2
            $table->string('image')->nullable();
            $table->string('type');
            $table->string('number');
            $table->string('size');
            $table->boolean('reserved')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
