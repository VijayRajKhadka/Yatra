<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalPlaceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'historical_place_image_id',
        'historical_place_image_name',
        'historical_place_image_path',
        
    ];
    protected $table = 'historical_place_images';

}
