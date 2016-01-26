<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
    public function line()
    {
    	return $this->belongsTo("App\Model\Line");
    }

    public function department()
    {
    	return $this->belongsTo("App\Model\Department");
    }

    public function designations()
    {
    	return $this->belongsToMany("App\Model\Designation",'employee_designation','employee_id','designation_id');
    }

    public function educations()
    {
    	return $this->hasMany("App\Model\Education");
    }

    public function experiences()
    {
    	return $this->hasMany("App\Model\Experience");
    }

    public function leave()
    {
        return $this->hasMany("App\Model\Leave");
    }

     public function leaveEmployees()
    {
        return $this->hasMany("App\Model\leaveEmployees");
    }

    public function grade()
    {
        return $this->belongsTo('App\Model\Grade');
    }

        public function attendance()
    {
        return $this->hasMany('App\Model\Attendance','');
    }

}
