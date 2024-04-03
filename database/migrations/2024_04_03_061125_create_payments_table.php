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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('pay_head');
            $table->date('due_date');
            $table->decimal('due_amount', 10, 2);
            $table->date('deposite_date')->nullable();
            $table->string('mode')->nullable();
            $table->string('receipt')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('surchange', 10, 2)->nullable();
            $table->string('prof_image')->nullable();
            $table->boolean('complete')->default(false);
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
