<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServiceOffer extends Model
{
    //
    public function offers(){
        return $this->hasMany(ServiceOffer::class,'service_id','id');
    }
}
