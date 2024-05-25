<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TrekController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\RestaurantController;
use App\Http\Controllers\API\WatchContentController;
use App\Http\Controllers\API\RecommendationController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TravelAgencyController;
use App\Http\Controllers\API\TopUserController;
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
    return response()->json($request->user(), 200);
});

Route::post("notification",[NotificationController::class, 'notifyapp'])->name('send.notification');

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');

});

Route::controller(UserController::class)->group(function(){
    Route::post('changePassword','changePassword');
    Route::post('changeProfile','updateProfilePic');
});

Route::controller(EventController::class)->group(function(){
    Route::get('verifiedRestaurant','getVerifiedRestaurant');
    Route::post('addRestaurantEvent','addRestaurantEvent');
    Route::get('restaurantEvents','getRestaurantEvents');
    Route::get('verifiedAgency','getVerifiedAgency');
    Route::post('addTravelEvent','addTravelEvent');
    Route::get('travelEvents','getTravelEvents');

});

Route::controller(TravelAgencyController::class)->group(function(){
    Route::post('addAgency','addTravelAgency');
    Route::post('addGuide','addTravelGuide');
    Route::get('travelAgency','getTravelGuide');
    Route::get('agencyGuide','getAgencyGuide');
    Route::put('deleteGuide','deleteGuideById');
     
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

Route::controller(HistoricalPlaceController::class)->group(function(){
    Route::get('historicalPlace','getHistoricalPlaces');
});


Route::controller(TopUserController::class)->group(function(){
    Route::get('topContributers','getTopUsers');
});

