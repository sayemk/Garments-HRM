<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->string('name',100);
            $table->tinyInteger('gender')->unsigned();
            $table->date('dob');
            $table->string('father_name',100);
            $table->string('mother_name',100)->nullable();
            $table->string('present_address',512);
            $table->string('permanent_address',512);
            $table->string('primary_phone',512);
            $table->string('secondary_phone',512)->nullable();
            $table->string('national_id',20)->nullable();
            $table->string('passport',20)->nullable();
            $table->string('birth_certificate',20);
            $table->string('image',256);
            $table->date('joining_date');
            $table->tinyInteger('status')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees');
    }
}
