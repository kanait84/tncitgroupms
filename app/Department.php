<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $table = 'departments';
	protected $primaryKey = 'd_id';

	public function user()
	{
		return $this->belongsTo('App\User', 'u_id', 'id');
	}

	public function subdepartment()
	{
		return $this->hasMany('App\Subdepartment', 'd_id', 'd_id');
	}
}
