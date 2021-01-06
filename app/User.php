<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','mobile', 'email', 'password','usertype','profile','code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products(){
        return $this->hasMany('App\Product');//user has many product
    }
    public function orders(){
        return $this->hasMany('App\Orders');//user has many order
    }
    public function reviews(){
        return $this->hasMany('App\Review');//user has many review
    }
    public function customs(){
        return $this->hasMany('App\CustomTask');//user has many review
    }
    public function messages(){
        return $this->hasMany('App\Message');//user has many messages
    }
}
