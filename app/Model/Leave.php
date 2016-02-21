<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    //
	public function employee()
    {
    	return $this->belongsTo("App\Model\Employee");
    }

    public function leaveDetails()
    {
    	return $this->hasMany('App\Model\LeaveDetail','leave_id','id');
    }

}
