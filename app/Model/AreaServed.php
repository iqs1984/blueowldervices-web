<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AreaServed extends Model
{
    //
    public function user_detail()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ServiceImages::class, 'user_id', 'user_id');
    }

}
