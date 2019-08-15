<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'r_id', 'u_id', 'date', 'description', 'attachment', 'file_type', 'remember_token', 'created_at', 'updated_at',
    ];

	public function user()
	{
		return $this->belongsTo('App\User', 'u_id', 'id');
	}


	public function comments()
	{
		return $this->hasMany('App\Comment', 'r_id', 'r_id');
	}

}
