<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdepartment extends Model
{
	protected $table = 'sub_departments';
	protected $primaryKey = 'sd_id';


	public function user()
	{
		return $this->belongsTo('App\User', 'u_id', 'id');
	}

	public function department()
	{
		return $this->belongsTo('App\Department', 'd_id', 'd_id');
	}
}
