<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TopUserController extends Controller
{
    public function getTopUsers(){
        $usersWithCounts = DB::table('users')
        ->leftJoin('place', function ($join) {
            $join->on('users.id', '=', 'place.added_by')
                ->where('place.approve', '=', 1);
        })
        ->leftJoin('trek', function ($join) {
            $join->on('users.id', '=', 'trek.added_by')
                ->where('trek.approve', '=', 1);
        })
        ->leftJoin('restaurant', function ($join) {
            $join->on('users.id', '=', 'restaurant.added_by')
                ->where('restaurant.approve', '=', 1);
        })
        ->select(
            'users.id',
            'users.name',
            'users.profile_url',
            DB::raw('COUNT(place.place_id) + COUNT(trek.trek_id) + COUNT(restaurant.restaurant_id) AS total_count')
        )
        ->groupBy('users.id', 'users.name', 'users.profile_url')
        ->orderByDesc('total_count')
        ->take(20)
        ->get();

        return response()->json($usersWithCounts); 

    }
}
