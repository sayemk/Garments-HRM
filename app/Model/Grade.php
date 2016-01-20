<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //
    public function designation()
    {
    	return $this->belongsTo("App\Model\Designation");
    }
}
