<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class HistoricalPlace extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'location',
        'map_url',
        'open_time',
        'latitude',
        'longitude',
        'get_there',
        'ticket_price',
        'contact_no'
    ];

    protected $primaryKey = "historical_place_id";

    function historical_place_image(){
        return $this->hasMany('App\Models\HistoricalPlaceImage','historical_place_id','historical_place_id');
    }
    function historical_monuments(){
        return $this->hasMany('App\Models\Monument','historical_place_id','historical_place_id');
    }

    protected $table = 'historical_places';
}
