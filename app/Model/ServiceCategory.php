<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServiceCategory extends Model
{
    //

    public function offers(){
        return $this->hasMany(ServiceOffer::class,'service_id','id');
    }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        if($this->image){
            return Storage::disk('public')->url($this->image);
        }else{

        }
    }
}
