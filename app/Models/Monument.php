<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'monument_imageUrl',
        'historical_place_id',
        
        
    ];
    protected $primaryKey = "monuments_id";
    protected $table = 'monuments';

}
