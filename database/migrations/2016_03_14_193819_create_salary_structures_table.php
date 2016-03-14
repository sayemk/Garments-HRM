<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->float('basic')->unsigned();
            $table->float('house_rent')->unsigned();
            $table->float('m_a')->unsigned();
            $table->float('t_a')->unsigned();
            $table->float('f_a')->unsigned();
            $table->float('gross')->unsigned();
            $table->tinyInteger('type')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('employee_id','type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('salary_structures');
    }
}
