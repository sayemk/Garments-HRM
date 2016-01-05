<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
    public function line()
    {
    	return $this->belongsToMany("App\Model\Line");
    }

    public function department()
    {
    	return $this->belongsTo("App\Model\Department");
    }

    public function designations()
    {
    	return $this->belongsToMany("App\Model\Designation");
    }

    public function educations()
    {
    	return $this->hasMany("App\Model\Education");
    }

    public function experiences()
    {
    	return $this->hasMany("App\Model\Experience");
    }
}
