<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holidays';

    public static function leaveType()
    {
    	return [
    		'1' =>'Weekly',
    		'2' => 'Government'
    	];	
    }
}
