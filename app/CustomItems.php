<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomItems extends Model
{
    protected $table = 'custom_items';

    protected $fillable = ['custom_id','product_id','quantity'];

    public function task(){
        return $this->belongsTo(CustomTask::class);    
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customItem()
    {
        return $this->hasMany('App\CustomItems');
    }

}
