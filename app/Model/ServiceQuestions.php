<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestions extends Model
{
    //

    protected  $appends = ['check'];

    function  getCheckAttribute(){
        $current_id = $this->id;
        $data = ServiceQuestions::whereQuestionId($current_id)->first();
        if($data){
            return true;
        }else{
            return false;
        }
    }
}
