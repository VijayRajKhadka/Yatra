<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'review',
        'rating'
        
    ];
    protected $table = 'restaurant_feedback';
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
