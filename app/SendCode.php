<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendCode extends Model
{
    public static function sendCode($mobile){
        $code = rand(00000,99999);
        $nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
            'to' => '+60'.(int)$mobile,
            'from' => 'Grand Zi-o',
            'text' => 'Verify code: '.$code,
        ]);
        return $code;
    }
}
