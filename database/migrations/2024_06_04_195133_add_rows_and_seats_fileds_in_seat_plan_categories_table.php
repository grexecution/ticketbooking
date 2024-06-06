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
        Schema::table('seat_plan_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('seat_plan_categories', 'rows')) {
                $table->integer('rows')->default(0)->after('places');
            }
            if (!Schema::hasColumn('seat_plan_categories', 'seats')) {
                $table->integer('seats')->default(0)->after('rows');
            }
            if (!Schema::hasColumn('seat_plan_categories', 'aisles_after')) {
                $table->string('aisles_after')->default('')->after('seats');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seat_plan_categories', function (Blueprint $table) {
            $table->dropColumn('rows');
            $table->dropColumn('seats');
            $table->dropColumn('aisles_after');
        });
    }
};
