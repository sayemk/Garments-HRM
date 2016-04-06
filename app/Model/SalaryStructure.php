<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryStructure extends Model
{
    use SoftDeletes;
    protected $table = 'salary_structures';

    public function employee(){
        return $this->belongsTo('App\Model\Employee','employee_id','id');
    }

    public function salaryRegister(){
        return $this->hasMany('App\Model\SalaryRegister');
    }
}
