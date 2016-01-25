<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LeaveEmployee extends Model
{

	protected $table = 'leave_employees';
    //
	public function employee()
    {
    	return $this->belongsTo("App\Model\Employee",'employee_id','id');
    }

    public function leaveType()
    {
    	return $this->belongsTo("App\Model\LeaveType",'leavetype_id','id');
    }


}
