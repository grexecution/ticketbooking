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
        Schema::create('event_artist', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('artist_id');
            $table->foreign('artist_id')
                ->references('id')->on('artists')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['event_id', 'artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_artist');
    }
};
