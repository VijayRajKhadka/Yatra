<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricalPlace;

class HistoricalPLaceController extends Controller
{
    public function getHistoricalPlaces(){
        $historicalPlaces = HistoricalPlace::where('isDeleted', 0)
        ->with(['historical_place_image', 'historical_monuments' => function ($query) {
            $query->where('isDeleted', 0);
        }])
        ->get();    
        return response()->json(['success' => true, 'data' => $historicalPlaces], 200);

    }
}
