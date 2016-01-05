<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /*Hide filled on model return and protect on Mass assignment*/
	protected $guarded = ["created_by","updated_by","created_at","updated_at","deleted_at"];
	protected $visible = ['name','address'];
    public function branches()
    {
    	return $this->hasMany("App\Model\Branch");
    }
}
