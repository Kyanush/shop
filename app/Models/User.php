<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'role_id'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company', 'user_id', 'id');
    }

    public function hasRole($check)
    {
        if(is_array($check)){
            if(in_array($this->role->name, $check))
                return true;
        }elseif($this->role->name == $check)
            return true;

        return false;
    }

}
