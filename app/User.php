<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const TOP_MANAGEMENT_TYPE = 'topmanagement';
    const MANAGEMENT_TYPE = 'management';
    const DEFAULT_TYPE = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'department', 'subdepartment', 'position', 'emp_photo', 'type',
    ];


    public function isAdmin()    {        
        return $this->type === self::ADMIN_TYPE;    
    }

    public function isManagement()    {        
        return $this->type === self::MANAGEMENT_TYPE;    
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


}
