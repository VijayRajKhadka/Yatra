<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'place_id',
        'user_id',
        'review',
        'rating'
        
    ];
    protected $table = 'place_feedback';
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
