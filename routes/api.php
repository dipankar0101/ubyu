<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/signUp', [ApiController::class, 'signUp']);
Route::post('/processSignup', [ApiController::class, 'processSignup']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/forgetPassword', [ApiController::class, 'forgetPassword']);
Route::post('/passwordOtpCheck', [ApiController::class, 'passwordOtpCheck']);
Route::post('/updateNewPassword', [ApiController::class, 'updateNewPassword']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::get('/checkLogin', [ApiController::class, 'checkLogin']);
    Route::get('/homePage', [ApiController::class, 'homePage']);
    Route::post('/accountUpdate', [ApiController::class, 'accountUpdate']);
    
});
Route::get('/termAndCondition', [ApiController::class, 'termAndCondition']);
Route::get('/contactDetail', [ApiController::class, 'contactDetail']);
