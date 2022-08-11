<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JnsAuditTrailController;
use App\Http\Controllers\JnsBlackListController;
use App\Http\Controllers\JnsBroadcastCLientCOntroller;
use App\Http\Controllers\JnsBroadcastDivisionController;
use App\Http\Controllers\JnsDeliveryReportController;
use App\Http\Controllers\JnsInvalidWordingController;
use App\Http\Controllers\JnsMaskingController;
use App\Http\Controllers\JnsWebUserController;
use App\Http\Controllers\M2mUserController;
use App\Http\Controllers\PctController;
use App\Http\Controllers\SmppUserController;
use App\Http\Controllers\UserContrroller;
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
    Route::resource('user', UserContrroller::class);
    
    //JNS
    Route::prefix('/jns')->group(function () {
       
        Route::resource('user', JnsWebUserController::class);
        Route::resource('division', JnsBroadcastDivisionController::class);
        Route::get('divisions/all',[JnsBroadcastDivisionController::class,'indexAll'])->name('divisions.all');
        Route::resource('client', JnsBroadcastCLientCOntroller::class);
        Route::get('clients/all',[JnsBroadcastCLientCOntroller::class,'indexAll'])->name('clients.all');
        Route::resource('audittrail', JnsAuditTrailController::class);
        Route::resource('blacklist', JnsBlackListController::class);
        Route::resource('invalidwording', JnsInvalidWordingController::class);
        Route::resource('deliveryreport', JnsDeliveryReportController::class);
        Route::resource('masking', JnsMaskingController::class);
    });
    //M2m
    Route::prefix('/m2m')->group(function () {
       
        Route::resource('user', M2mUserController::class);
    });

    Route::prefix('/smpp')->group(function () {
       
        Route::resource('user', SmppUserController::class);
    });

    //PCT
    Route::prefix('/pct')->group(function () {
        Route::get('/client',[PctController::class,'clientList']);
    });


});







