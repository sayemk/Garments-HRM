<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    //
    public function leave()
    {
    	return $this->hasMany("App\Model\leave");
    }

    //
    public function leaveEmployee()
    {
    	return $this->hasMany("App\Model\leaveEmployee");
    }
}
