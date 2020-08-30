<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public $timestamp = true;
    public function user(){
        return $this->belongsTo('App\User');//product has relationship with user and belong to user
    }

    public function category(){
        return $this->belongsTo('App\Category');//product has relationship with category and belong to category
    }
    public function reviews(){
        return $this->hasMany('App\Review');//product has relationship with Review
    }

}
