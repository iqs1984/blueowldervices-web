<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VendorEmployee extends Model
{
    //
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        if($this->imgpath){
            return Storage::disk('public')->url($this->imgpath);
        }else{
            return asset('images/vendor-img.jpg');
        }
    }

}
