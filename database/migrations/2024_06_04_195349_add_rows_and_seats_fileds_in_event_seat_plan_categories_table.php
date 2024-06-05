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
        Schema::table('event_seat_plan_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'rows')) {
                $table->integer('rows')->default(0)->after('places');
            }
            $table->integer('seats')->default(0)->after('rows');
            $table->string('aisles_after')->default('')->after('seats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_seat_plan_categories', function (Blueprint $table) {
            $table->dropColumn('rows');
            $table->dropColumn('seats');
            $table->dropColumn('aisles_after');
        });
    }
};
