<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\MonumentController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-mail',[MailController::class,'index']);

Route::get('/login',function(){
    return redirect('/login');
});
Route::get('/login',[AuthController::class,'loadLogin']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout']);


// ********** Super Admin Routes *********
Route::group(['prefix' => 'super-admin','middleware'=>['web','isSuperAdmin']],function(){
    Route::get('/dashboard',[DashboardController::class,'dashboard']);
    Route::get('/user',[SuperAdminController::class,'users'])->name('users');
    Route::get('/event',[SuperAdminController::class,'events'])->name('events');

    Route::get('/searchUsers', [SuperAdminController::class, 'searchUsers'])->name('searchUsers');
    Route::get('/editUser/{id}', [SuperAdminController::class, 'editUser'])->name('userDetails');
    Route::put('/updateUser/{id}',[SuperAdminController::class,'updateUser'])->name('updateUser');
    Route::put('/deleteUser/{id}',[SuperAdminController::class,'deleteUser'])->name('deleteUser');

    Route::get('/historicalPlaces',[SuperAdminController::class,'historicalPlaces'])->name('historicalPlaces');
    Route::get('/addHistoricalPlaces',[SuperAdminController::class,'addHistoricalPlaces'])->name('addHistoricalPlace');
    Route::post('/submitHistPlaceForm',[SuperAdminController::class,'submitHistPlaceForm'])->name('submitHistPlaceForm');
    Route::get('/historicalPlace/{historical_place_id}',[SuperAdminController::class,'getHistoricalPlaces'])->name('historicalPlaceDetails');
    Route::put('/updatehistoricalPlace/{historical_place_id}',[SuperAdminController::class,'updateHistDetails'])->name('updateHistoricalPlace');
    Route::post('/addMonument',[MonumentController::class,'addMonument'])->name('addMonument');
    Route::put('/updateMonument/{monuments_id}',[MonumentController::class,'updateMonument'])->name('updateMonument');
    Route::put('/deleteMonument/{monuments_id}',[MonumentController::class,'deleteMonument'])->name('deleteMonument');
    Route::put('/deleteHistoricalPlace/{historical_place_id}',[SuperAdminController::class,'deleteHistoricalPlace'])->name('deleteHistoricalPlace');

    
});

// ********** Sub Admin Routes *********
Route::group(['prefix' => 'admin','middleware'=>['web','isAdmin']],function(){
    Route::get('/dashboard',[AdminController::class,'dashboard']);
    Route::get('/trek/{approve}', [AdminController::class, 'treks'])->name('adminTrek');
    Route::get('/trekDetails/{trek_id}',[AdminController::class,'getTrekDetails'])->name('trekDetails');
    Route::put('/updateTrek/{trek_id}',[AdminController::class,'updateTrekDetails'])->name('updateTrekDetails');
    Route::get('/searchTrek', [AdminController::class, 'searchTrek'])->name('searchTrek');

    Route::get('/place/{approve}', [AdminController::class, 'place'])->name('adminPlace');
    Route::get('/placeDetails/{place_id}',[AdminController::class,'getPlaceDetails'])->name('placeDetails');
    Route::put('/updatePlace/{place_id}',[AdminController::class,'updatePlaceDetails'])->name('updatePlaceDetails');
    Route::get('/searchPlace', [AdminController::class, 'searchPlace'])->name('searchPlace');

    Route::get('/restaurant/{approve}', [AdminController::class, 'restaurant'])->name('adminRestaurant');
    Route::get('/restaurantDetails/{restaurant_id}', [AdminController::class, 'getRestaurantDetails'])->name('restaurantDetails');
    Route::put('/updateRestaurant/{restaurant_id}', [AdminController::class, 'updateRestaurantDetails'])->name('updateRestaurantDetails');
    Route::get('/searchRestaurant', [AdminController::class, 'searchRestaurant'])->name('searchRestaurant');


});