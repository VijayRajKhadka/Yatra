<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'restaurant_id',
        'location',
        'open_time',
        'start_time',
        'end_time',
        'title',
        'body',
        'event_image_path',
    ];
    protected $table = 'restaurant_events';
    protected $primaryKey = "event_id";

}
