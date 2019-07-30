<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_id', 'r_id', 'comment', 'remember_token', 'created_at', 'updated_at'
    ];


	public function user()
	{
		return $this->belongsTo('App\User', 'u_id', 'id');
	}

    public function report()
    {
        return $this->belongsTo('App\Report', 'r_id', 'r_id');
    }


}
