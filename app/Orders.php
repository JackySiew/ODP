<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public function items(){
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id');
    }

    public function products(){
        return $this->belongsToMany('App\Product')->withPivot('quantity');
     }

    public function user(){
        return $this->belongsTo('App\User');
     }

    public function orderItem()
    {
        return $this->hasMany(OrderItems::class );
    }
 }
