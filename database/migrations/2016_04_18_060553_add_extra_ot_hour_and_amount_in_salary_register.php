<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraOtHourAndAmountInSalaryRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_registers', function (Blueprint $table) {
            $table->float('extra_ot_hour')->unsigned();
            $table->float('extra_ot_amount')->unsigned();
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
            $table->dropColumn(['extra_ot_hour','extra_ot_amount']);
        });
    }
}
