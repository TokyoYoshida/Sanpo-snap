<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function followers()
    {
        return $this->hasMany('App\Follow' ,'followee_id');
    }

    public function follows()
    {
        return $this->hasMany('App\Follow' ,'follower_id');
    }

    public function favs()
    {
        return $this->hasMany('App\Fav');
    }

    public function accounts(){
        return $this->hasMany('App\LinkedSocialAccount');
    }
}
