<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    //
    public function services(){
        return $this->belongsTo(ServiceCategory::class,'service_id','id');
    }
    public function location(){
        return $this->belongsTo(AreaServed::class,'location_id','id');
    }
}
