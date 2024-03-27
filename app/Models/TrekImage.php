<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrekImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'trek_id',
        'trek_image_name',
        'trek_image_path',
        
    ];
    protected $table = 'trek_image';

    


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];
}
