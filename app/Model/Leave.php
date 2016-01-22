<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    //
	public function employees()
    {
    	return $this->belongsTo("App\Model\Employees");
    }

    public function leaveType()
    {
    	return $this->belongsTo("App\Model\LeaveType");
    }

}
