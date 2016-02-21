<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LeaveDetail extends Model
{
    protected $table = 'leave_details';
    public function leave()
    {
    	return $this->belongsTo('App\Model\Leave');
    }
}
