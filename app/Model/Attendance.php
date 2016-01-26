<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

	protected $table = 'attendances';

    public function employees()
    {
    	return $this->belongsTo("App\Model\Employee",'employee_id','id');
    }
}
