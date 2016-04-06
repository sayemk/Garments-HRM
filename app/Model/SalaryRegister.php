<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryRegister extends Model
{
    use SoftDeletes;
    protected $table='salary_registers';

    public function employee(){
        return $this->belongsTo('App\Model\Employee','employee_id','id');
    }

    public function salaryStructure(){
        return $this->belongsTo('App\Model\SalaryStructure','salary_structure_id','id');
    }
}
