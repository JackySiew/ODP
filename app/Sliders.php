<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $table = 'sliders';
    protected $fillable =[
        'heading',
        'description',
        'link',
        'link_name',
        'image',
        'status',
        
    ];
}
