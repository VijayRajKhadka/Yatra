<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'restaurant_id',
        'restaurant_image_name',
        'restaurant_image_path',
        
    ];
    protected $table = 'restaurant_image';

   
}
