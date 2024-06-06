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
            $table->unsignedBigInteger('subscription_id')->nullable()->after('event_id');
            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_seat_plan_categories', function (Blueprint $table) {
            $table->dropForeign('event_seat_plan_categories_subscription_id_foreign');
            $table->dropColumn('subscription_id');
        });
    }
};
