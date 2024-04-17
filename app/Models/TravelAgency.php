<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelAgency extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'location',
        'contact_no',
        'document_url',
        'registration_no',
        'agency_image_url',
        'added_by',
    ];
    protected $primaryKey = "agency_id";
    protected $table = 'travel_agency';

    function travel_guides(){
        return $this->hasMany('App\Models\TravelGuide','agency_id','agency_id');
    }
}
