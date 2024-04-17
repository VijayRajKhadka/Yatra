<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelGuide extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact',
        'profile_url',
        'experience',
        'agency_id',
        
    ];
    protected $primaryKey = "guide_id";
}
