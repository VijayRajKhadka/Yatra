<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrekFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'trek_id',
        'user_id',
        'review',
        'rating'
        
    ];
    protected $table = 'trek_feedback';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
