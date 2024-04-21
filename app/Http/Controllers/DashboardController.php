<?php

namespace App\Http\Controllers;

use App\Models\Trek;
use App\Models\User;
use App\Models\Place;
use App\Models\Restaurant;
use App\Models\TravelGuide;
use App\Models\TravelEvents;
use App\Models\TrekFeedback;
use Illuminate\Http\Request;
use App\Models\PlaceFeedback;
use App\Models\HistoricalPlace;
use App\Models\RestaurantEvent;
use App\Models\RestaurantFeedback;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {   
        $userCount = User::where('Role', 0)->count();
        $trekCount = Trek::where('approve',1)->count();
        $restaurantCount = Restaurant::where('approve',1)->count();
        $placeCount = Place::where('approve',1)->count();
        $travelEvents = TravelEvents::count();
        $restraurantEvents = RestaurantEvent::count();
        $totalEvents = $travelEvents+$restraurantEvents;
        $trekReviews = TrekFeedback::whereNotNull('review')->count();
        $placeReviews = PlaceFeedback::whereNotNull('review')->count();
        $restaurantReviews = RestaurantFeedback::whereNotNull('review')->count();
        $totalReviews = $trekReviews +$placeReviews+$restaurantReviews;
        $totalGuides= TravelGuide::count();
        $historicalPlaceCount = HistoricalPlace::where('isDeleted',0)->count();

        $barGraphData = [
            'labels' => ['Treks', 'Restaurants', 'Places', 'Historical Places'],
            'data' => [$trekCount, $restaurantCount, $placeCount, $historicalPlaceCount]
        ];
        
        $userCountsPerMonth = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year', 'month')
            ->get();
        
        return view('super-admin.dashboard', compact('userCount','trekCount','restaurantCount','placeCount', 
        'totalEvents','totalReviews','totalGuides','barGraphData','userCountsPerMonth'));
    }
}
