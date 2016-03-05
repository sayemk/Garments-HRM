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

    /**
     * @param $value
     * @return string
     */
    public function getStartDayAttribute($value){
        $time = strtotime($value);
        return date('d/m/Y',$time);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getEndDayAttribute($value){
        $time = strtotime($value);
        return date('d/m/Y',$time);
    }

}
