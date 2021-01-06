<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomTask extends Model
{
    protected $table = 'customize';

    public function items(){
        return $this->belongsToMany(Product::class,'custom_items','custom_id','product_id');
    }

    public function products(){
        return $this->belongsToMany('App\Product');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function orderItem()
    {
        return $this->hasMany(CuustomItems::class );
    }

}
