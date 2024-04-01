<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'category',
        'open_time',
        'latitude',
        'longitude',
        'get_there',
        
    ];
    protected $primaryKey = "place_id";

    function place_image(){
        return $this->hasMany('App\Models\PlaceImage','place_id','place_id');
    }
    function place_feedback(){
        return $this->hasMany('App\Models\PlaceFeedback','place_id','place_id');
    }
    protected $table = 'place';
}
