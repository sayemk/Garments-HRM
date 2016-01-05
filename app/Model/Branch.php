<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    
    
    public function organization()
    {
    	return $this->belongsTo("App\Model\Organization");
    }

    public function departments()
    {
    	return $this->hasMany("App\Model\Department");
    }
}
