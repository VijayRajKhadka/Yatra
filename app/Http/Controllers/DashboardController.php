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
    public function superAdminDashboard()
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


        $categories = ['Trek', 'Place', 'Restaurant'];
        $reviewsCount = [$trekReviews, $placeReviews, $restaurantReviews];
        $mostReviewedCategory = $categories[array_search(max($reviewsCount), $reviewsCount)];

        $pieChartData = [
            'labels' => $categories,
            'data' => $reviewsCount,
            'mostReviewedCategory' => $mostReviewedCategory,
        ];
        

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
            ->take(3)
            ->get();

        
        return view('super-admin.dashboard', compact('userCount','trekCount','restaurantCount','placeCount', 
        'totalEvents','totalReviews','totalGuides','barGraphData','userCountsPerMonth','pieChartData','usersWithCounts'));
    }

    public function AdminDashboard(){
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


        $categories = ['Trek', 'Place', 'Restaurant'];
        $reviewsCount = [$trekReviews, $placeReviews, $restaurantReviews];
        $mostReviewedCategory = $categories[array_search(max($reviewsCount), $reviewsCount)];

        $pieChartData = [
            'labels' => $categories,
            'data' => $reviewsCount,
            'mostReviewedCategory' => $mostReviewedCategory,
        ];
        

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
            ->take(3)
            ->get();

        
        return view('admin.dashboard', compact('userCount','trekCount','restaurantCount','placeCount', 
        'totalEvents','totalReviews','totalGuides','barGraphData','userCountsPerMonth','pieChartData','usersWithCounts'));
    }
}
