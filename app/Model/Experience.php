<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    

    public function employee()
    {
    	return $this->belongsTo("App\Model\Employee");
    }
}
