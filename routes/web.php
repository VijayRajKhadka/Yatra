<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

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
    Route::get('/dashboard',[SuperAdminController::class,'dashboard']);

});

// ********** Sub Admin Routes *********
Route::group(['prefix' => 'admin','middleware'=>['web','isAdmin']],function(){
    Route::get('/dashboard',[AdminController::class,'dashboard']);
    Route::get('/trek',[AdminController::class,'treks'])->name('adminTrek');
    Route::get('/trek/{trek_id}',[AdminController::class,'getTrekDetails'])->name('trekDetails');
    Route::put('/updateTrek/{trek_id}',[AdminController::class,'updateTrekDetails'])->name('updateTrekDetails');

});