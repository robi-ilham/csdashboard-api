<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CproAuditTrail;
use App\Http\Controllers\CproClient;
use App\Http\Controllers\CproDivisionController;
use App\Http\Controllers\CproSender;
use App\Http\Controllers\CproUser;
use App\Http\Controllers\JnsAuditTrailController;
use App\Http\Controllers\JnsBlackListController;
use App\Http\Controllers\JnsBroadcastCLientCOntroller;
use App\Http\Controllers\JnsBroadcastDivisionController;
use App\Http\Controllers\JnsDeliveryReportController;
use App\Http\Controllers\JnsInvalidWordingController;
use App\Http\Controllers\JnsMaskingController;
use App\Http\Controllers\JnsPrefixController;
use App\Http\Controllers\JnsPrivilegeController;
use App\Http\Controllers\JnsTokenBalanceController;
use App\Http\Controllers\JnsTokenMapController;
use App\Http\Controllers\JnsWaTemplateController;
use App\Http\Controllers\JnsWebGroupController;
use App\Http\Controllers\JnsWebUserController;
use App\Http\Controllers\M2mUserController;
use App\Http\Controllers\PctController;
use App\Http\Controllers\SmppUserController;
use App\Http\Controllers\UserContrroller;
use App\Http\Controllers\WaiUSerController;
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
Route::prefix('/cpro')->group(function () { 
    Route::resource('user', CproUser::class);
    Route::resource('division', CproDivisionController::class);
    Route::resource('client', CproClient::class);
    Route::resource('sender', CproSender::class);
    Route::resource('audit-trail', CproAuditTrail::class);
});

Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::resource('user', UserContrroller::class);
    
    //JNS
    Route::prefix('/jns')->group(function () {
        Route::resource('group', JnsWebGroupController::class);
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
        Route::resource('prefix', JnsPrefixController::class);
        Route::resource('privilege', JnsPrivilegeController::class);
        Route::resource('tokenbalance', JnsTokenBalanceController::class);
        Route::resource('tokenmap', JnsTokenMapController::class);
        Route::resource('watemplate', JnsWaTemplateController::class);

    });
    //M2m
    Route::prefix('/m2m')->group(function () {
       
        Route::resource('user', M2mUserController::class);
    });

    Route::prefix('/smpp')->group(function () {
       
        Route::resource('user', SmppUserController::class);
    });

    Route::prefix('/wai')->group(function () {
       
        Route::resource('user', WaiUSerController::class);
    });
    //PCT
    Route::prefix('/pct')->group(function () {
        Route::get('/client',[PctController::class,'clientList']);
    });


});







