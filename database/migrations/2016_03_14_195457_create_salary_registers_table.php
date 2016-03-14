<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('salary_structure_id')->unsigned();
            $table->float('basic')->unsigned();
            $table->float('house_rent')->unsigned();
            $table->float('m_a')->unsigned();
            $table->float('t_a')->unsigned();
            $table->float('f_a')->unsigned();
            $table->float('gross')->unsigned();
            $table->tinyInteger('abs_days')->unsigned();
            $table->float('abs_deduction')->unsigned();
            $table->float('net_salary')->unsigned();
            $table->float('att_bonus')->unsigned();
            $table->float('ot_rate')->unsigned();
            $table->float('ot_hours')->unsigned();
            $table->float('ot_amount')->unsigned();
            $table->float('payable')->unsigned();
            $table->float('adv_amount')->unsigned();
            $table->float('stamp')->unsigned();
            $table->float('net_paid')->unsigned();
            $table->tinyInteger('month')->unsigned();
            $table->integer('year')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('employee_id','salary_structure_id',['year','month']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('salary_registers');
    }
}
