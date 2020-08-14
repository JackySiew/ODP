<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table= 'orders';

    public function user(){
        return $this->belongsTo('App\User');//product has relationship with user and belong to user
    }

    public function products(){
        return $this->hasMany('App\Product');//order has many product
    }
}
