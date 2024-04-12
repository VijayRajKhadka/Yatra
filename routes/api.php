<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TrekController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\RestaurantController;
use App\Http\Controllers\API\WatchContentController;
use App\Http\Controllers\API\RecommendationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
});
Route::controller(TrekController::class)->group(function(){
    Route::post('addTrek','addTrek');
    Route::get('trek','getTrekDetails');
    Route::get('trekDetails','getTrekByID');
    Route::post('addTrekFeedback','addTrekFeedback');
    Route::get('trekReview','getTrekReview');

});
Route::controller(WatchContentController::class)->group(function(){
    Route::get('getWatchContent','getWatchContent');
    Route::post('addContent','contentRegister');
});

Route::controller(PlaceController::class)->group(function(){
    Route::post('addPlace','addPlace');
    Route::get('place','getPlaceDetails');
    Route::get('placeDetails','getPlaceByID');
    Route::post('addPlaceFeedback','addPlaceFeedback');
    Route::get('placeReview','getPlaceReview');

});
Route::controller(RestaurantController::class)->group(function(){
    Route::post('addRestaurant','addRestaurant');
    Route::get('restaurantDetails','getRestaurantByID');
    Route::get('restaurant','getRestaurantDetails');
    Route::post('addRestaurantFeedback','addRestaurantFeedback');
    Route::get('restaurantReview','getRestaurantReview');
});

Route::controller(RecommendationController::class)->group(function(){
    Route::post('predict','predict');
});