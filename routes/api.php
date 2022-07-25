<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PctController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/client',[PctController::class,'clientList']);
    

    Route::prefix('/pct')->group(function () {
        Route::get('/client',[PctController::class,'clientList']);
    });


});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


