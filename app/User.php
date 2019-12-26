<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const TOP_MANAGEMENT_TYPE = 'topmanagement';
    const MANAGEMENT_TYPE = 'management';
    const SUBMANAGEMENT_TYPE = 'submanagement';
    const DEFAULT_TYPE = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'd_id', 'sd_id', 'position', 'emp_photo', 'emp_sign', 'file_type', 'type',
    ];


    public function isAdmin()    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isManagement()    {
        return $this->type === self::MANAGEMENT_TYPE;
    }

    public function isSubmanagement()    {
        return $this->type === self::SUBMANAGEMENT_TYPE;
    }

    public function isTopManagement()    {
        return $this->type === self::TOP_MANAGEMENT_TYPE;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

       /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
       protected $guarded = [
        'role'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function reports()
    {
        return $this->hasMany('App\Report', 'u_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo('App\Report', 'u_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'u_id', 'id');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment', 'u_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'd_id', 'd_id');
    }

    public function subdepartment()
    {
        return $this->belongsTo('App\Subdepartment', 'sd_id', 'sd_id');
    }

    public function manager_departments()
    {
        return $this->hasMany('App\Department', 'd_id', 'd_id');
    }

}
