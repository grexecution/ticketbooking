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
        Schema::create('event_seat_plan_categories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('seat_plan_id')->nullable();
            $table->foreign('seat_plan_id')
                ->references('id')->on('seat_plans')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('name', 255);
            $table->float('price');
            $table->integer('places')->default(0);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_seat_plan_categories');
    }
};
