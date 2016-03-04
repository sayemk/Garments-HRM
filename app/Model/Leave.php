<?php

namespace App\Model;

use Carbon\Carbon;
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

    public function getStart_day($value){
        return Carbon::createFromFormat('Y-m-d',$value)->toDateString('d/m/Y');
    }

}
