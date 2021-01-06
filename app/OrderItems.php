<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';

    protected $fillable = ['order_id','product_id','quantity'];

    public function order(){
        return $this->belongsTo(Orders::class);    
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orderItem()
    {
        return $this->hasMany('App\OrderItems');
    }

}
