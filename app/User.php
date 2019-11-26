<?php

namespace App;

use App\Model\ServiceCategory;
use App\Model\ServiceImages;
use App\Model\ServiceOffer;
use App\Model\UserOffers;
use App\Model\VendorEmployee;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'service_offered'=>'array'
    ],$appends = ['image_url'];


    public function services(){
        return $this->belongsTo(ServiceCategory::class,'service_category','id');
    }
    public function images(){
        return $this->hasMany(ServiceImages::class,'user_id','id');
    }
    public function employees(){
        return $this->hasMany(VendorEmployee::class,'user_id','id');
    }

    public function useroffer(){
        return $this->belongsToMany(UserOffers::class, 'user_offers','user_id', 'offered_id');
    }

    public function getImageUrlAttribute(){
        if($this->imgpath){
            return Storage::disk('public')->url($this->imgpath);
        }else{
            return asset('images/vendor-img.jpg');
        }
    }
}
