<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    
    public function section()
    {
    	return $this->belongsTo("App\Model\Section");
    }

    public function employees()
    {
    	return $this->belongsToMany("App\Model\Employee");
    }
}
