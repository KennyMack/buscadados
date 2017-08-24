<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Company;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'lastname', 
        'email', 
        'password', 
        'type',
        'isactive',
        'firstlogin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'type',
        'isactive',
        'firstlogin',
    ];

    public function isAdmin()
    {
        return $this->type == 1;
    }

    public function completeName()
    {
        return $this->name. ' '. $this->lastname;
    }

    public function company()
    {
        return $this->hasMany('App\Company', 'user_id', 'id')->first();
    }

    public function hasCompany()
    {
        return Company::where('user_id', $this->id)->count() > 0;
    }

    public function companyIsEnabled()
    {
        if ($this->hasCompany())
            return $this->company()->isEnabled();

        return false;
    }

    public function registrationCompleted()
    {
        return $this->hasCompany() && $this->firstlogin != 1;
    }
}
