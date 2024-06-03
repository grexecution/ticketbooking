<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSeatPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seat_plans', function (Blueprint $table) {
            $table->integer('seatCount')->after('is_custom');
            $table->string('aislesAfter')->after('seatCount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seat_plans', function (Blueprint $table) {
            $table->dropColumn('seatCount');
            $table->dropColumn('aislesAfter');
        });
    }
}
