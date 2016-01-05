<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    
    public function employees()
    {
    	return $this->belongsToMany("App\Model\Employee");
    }
}
