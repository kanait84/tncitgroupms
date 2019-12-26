<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverTimeRequests extends Model
{
    //
    protected $table = 'overtimerequests';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'u_id', 'date', 'start_time', 'end_time', 'reason', 'report_uid', 'mgr_id', 'ot_file',
        'file_type', 'status', 'remember_token', 'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'u_id', 'u_id');
    }

    public function reportuser()
    {
        return $this->belongsTo('App\User', 'u_id', 'report_uid');
    }

    public function manager()
    {
        return $this->belongsTo('App\User', 'u_id', 'mgr_id');
    }

}
