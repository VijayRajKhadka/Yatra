<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchContent extends Model
{
    use HasFactory;

    protected $table = 'watchcontent';

    protected $fillable = [
        'content_url',
        'added_by' 
    ];
}
