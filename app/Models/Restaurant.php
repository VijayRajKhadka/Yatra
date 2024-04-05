<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'category',
        'affordability',
        'open_time',
        'latitude',
        'longitude',
        'get_there',
        'pan'
        
    ];
    protected $table = 'restaurant';
    protected $primaryKey = "restaurant_id";

    
    function restaurant_image(){
        return $this->hasMany('App\Models\RestaurantImage','restaurant_id','restaurant_id');
    }
}
