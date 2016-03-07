<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LeaveDetail extends Model
{
    protected $table = 'leave_details';
   
    public function leave()
    {
    	return $this->belongsTo('App\Model\Leave');
    }

    public function leaveType()
    {
    	return $this->belongsTo('App\Model\LeaveType','leave_type_id');
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
