<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{

	protected $table = 'attendances';

	protected $fillable = array('employee_id', 'date', 'in_time');
    public function employees()
    {
    	return $this->belongsTo("App\Model\Employee",'employee_id','id');
    }

    public function getDateAttribute($value)
    {
    	 return Carbon::parse($value)->format('d/m/Y');
    }
}
