<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = "designations";
    public function employees()
    {
    	return $this->belongsToMany("App\Model\Employee");
    }
}
