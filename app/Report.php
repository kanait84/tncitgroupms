<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{


	public function user()
	{
		return $this->belongsTo('App\User', 'u_id', 'id');
	}


	public function comments()
	{
		return $this->hasMany('App\Comment', 'r_id', 'r_id');
	} 

}
