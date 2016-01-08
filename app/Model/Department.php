<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    

    public function branch()
    {
    	return $this->belongsTo("App\Model\Branch");
    }

    public function section()
    {
    	return $this->hasMany("App\Model\Section");
    }
}
