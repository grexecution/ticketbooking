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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('venue_id');
            $table->foreign('venue_id')
                ->references('id')->on('venues')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('name', 255)->nullable();
            $table->string('artist', 64)->nullable()->index();
            $table->boolean('active')->default(false)->index();
            $table->string('status', 16)->default('hidden')->index();
            $table->timestamp('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('doors_open_time')->nullable();
            $table->float('price')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
