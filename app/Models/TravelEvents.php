<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelEvents extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_no',
        'agency_id',
        'email',
        'location',
        'start_time',
        'end_time',
        'title',
        'body',
        'event_image_path',
    ];
    protected $table = 'travel_events';
    protected $primaryKey = "event_id";
}
