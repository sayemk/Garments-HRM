<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtRateInSalaryStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_structures', function (Blueprint $table) {
            $table->float('ot_rate')->after('f_a');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_structure', function (Blueprint $table) {
            $table->dropColumn('ot_rate');
        });
    }
}
