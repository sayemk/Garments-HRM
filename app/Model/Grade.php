<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
	//method for branch
	public function branch()
	{
		return $this->belongsTo("App\Model\Branch");
	}

	//function for department
	public function department()
	{
		return $this->belongsTo("App\Model\Department");
	}

	// function for section
    public function section()
    {
    	return $this->belongsTo("App\Model\Section");
    }

    //method for designation
    public function designation()
    {
    	return $this->belongsTo("App\Model\Designation");
    }

}
