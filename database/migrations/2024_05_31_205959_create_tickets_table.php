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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('event_seat_plan_category_id');
            $table->foreign('event_seat_plan_category_id')
                ->references('id')->on('event_seat_plan_categories')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('voucher_id')
                ->references('id')->on('vouchers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('voucher_name')->nullable();
            $table->string('category_name')->nullable();
            $table->string('discount')->nullable();
            $table->float('price')->nullable();
            $table->float('total')->nullable();
            $table->boolean('is_refunded')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_cancelled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
