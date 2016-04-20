<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdddaysFieldInSalaryRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_registers', function (Blueprint $table) {
            $table->tinyInteger('days_of_month')->unsigned();
            $table->tinyInteger('present_days')->unsigned();
            $table->tinyInteger('no_holidays')->unsigned();
            $table->tinyInteger('leave_days')->unsigned();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_registers', function (Blueprint $table) {
            $table->dropColumn(['days_of_month','present_days','no_holidays','leave_days']);
        });
    }
}
