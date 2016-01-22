<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function employees()
    {
    	return $this->belongsTo("App\Model\Employees");
    }
}
