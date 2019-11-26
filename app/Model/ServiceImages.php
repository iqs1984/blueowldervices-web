<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServiceImages extends Model
{
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        if($this->file_type){
            return Storage::disk('public')->url($this->file_type);
        }else{

        }
    }
}
