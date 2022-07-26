<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CproAuditTrail;
use App\Http\Controllers\CproBroadcastController;
use App\Http\Controllers\CproButtonController;
use App\Http\Controllers\CproChatbotController;
use App\Http\Controllers\CproClient;
use App\Http\Controllers\CproDivisionController;
use App\Http\Controllers\CproDownloadReport;
use App\Http\Controllers\CproHelpdeskController;
use App\Http\Controllers\CproSender;
use App\Http\Controllers\CproTemplate;
use App\Http\Controllers\CproUser;
use App\Http\Controllers\CstoolAuditController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DrCategory;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\JnsAuditTrailController;
use App\Http\Controllers\JnsBlackListController;
use App\Http\Controllers\JnsBroadcastCLientController;
use App\Http\Controllers\JnsBroadcastDivisionController;
use App\Http\Controllers\JnsDeliveryReportController;
use App\Http\Controllers\JnsInvalidWordingController;
use App\Http\Controllers\JnsMaskingController;
use App\Http\Controllers\JnsPrefixController;
use App\Http\Controllers\JnsPrivilegeController;
use App\Http\Controllers\JnsProviderController;
use App\Http\Controllers\JnsTokenBalanceController;
use App\Http\Controllers\JnsTokenMapController;
use App\Http\Controllers\JnsWaTemplateController;
use App\Http\Controllers\JnsWebGroupController;
use App\Http\Controllers\JnsWebUserController;
use App\Http\Controllers\M2mUserController;
use App\Http\Controllers\PctClientController;
use App\Http\Controllers\PctController;
use App\Http\Controllers\PctDivisionController;
use App\Http\Controllers\PctDivisionOwner;
use App\Http\Controllers\PrivilegeTypeController;
use App\Http\Controllers\ReportCpro;
use App\Http\Controllers\senderControlller;
use App\Http\Controllers\SmppUserController;
use App\Http\Controllers\SmsPushReportController;
use App\Http\Controllers\UserContrroller;
use App\Http\Controllers\WaiUSerController;
use App\Http\Controllers\WaPushReportController;
use App\Http\Controllers\WebhookController;
use App\Models\PctClientDivision;
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

Route::resource('alert', AlertController::class);

Route::prefix('/cpro')->group(function () { 
    Route::post('download/summary',[CproDownloadReport::class,'summary'])->name('download.summary');
    Route::post('download/detail',[CproDownloadReport::class,'detail'])->name('download.detail');
    
    Route::post('user/reset-password',[CproUser::class,'resetPassword'])->name('user.resetpassword');
    Route::resource('user', CproUser::class);
    Route::get('division/index-api',[CproDivisionController::class,'indexApi'])->name('division.indexapi');
    Route::resource('division', CproDivisionController::class);
    Route::resource('client', CproClient::class);
    Route::resource('sender', CproSender::class);
    Route::resource('audit-trail', CproAuditTrail::class);
    Route::resource('broadcast', CproBroadcastController::class);
    Route::resource('button', CproButtonController::class);
    Route::resource('chatbot', CproChatbotController::class);
    Route::resource('helpdesk', CproHelpdeskController::class);
    Route::get('template/list',[CproTemplate::class,'list'])->name('template.list');
    Route::resource('template', CproTemplate::class);
});

Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('user/reset-password',[UserContrroller::class,'resetPassword'])->name('user.resetpassword');
    Route::resource('user', UserContrroller::class);
    Route::resource('audit', CstoolAuditController::class);
    Route::resource('information', InformationController::class);

   


    
    //JNS
    Route::prefix('/jns')->group(function () {
        Route::resource('group', JnsWebGroupController::class);

        Route::get('user/index-ajax',[JnsWebUserController::class,'indexAjax'])->name('user.ajax');
        Route::post('user/reset-password',[JnsWebUserController::class,'resetPassword'])->name('user.resetpassword');
        Route::resource('user', JnsWebUserController::class);

        Route::resource('division', JnsBroadcastDivisionController::class);
        Route::get('divisions/all',[JnsBroadcastDivisionController::class,'indexAll'])->name('divisions.all');

        Route::resource('client', JnsBroadcastCLientController::class);
        Route::get('clients/all',[JnsBroadcastCLientCOntroller::class,'indexAll'])->name('clients.all');

        Route::resource('providers', JnsProviderController::class);

        Route::get('audittrail/index-ajax',[JnsAuditTrailController::class,'indexAjax'])->name('audittrail.ajax');
        Route::resource('audittrail', JnsAuditTrailController::class);

        Route::get('blacklist/index-ajax',[JnsBlackListController::class,'indexAjax'])->name('blacklist.ajax');
        Route::resource('blacklist', JnsBlackListController::class);

        Route::get('invalidwording/index-ajax',[JnsInvalidWordingController::class,'indexAjax'])->name('invalidwording.ajax');
        Route::resource('invalidwording', JnsInvalidWordingController::class);
        
        Route::get('deliveryreport/index-ajax',[JnsDeliveryReportController::class,'indexAjax'])->name('deliveryreport.ajax');
        Route::resource('deliveryreport', JnsDeliveryReportController::class);

        Route::get('masking/index-ajax',[JnsMaskingController::class,'indexAjax'])->name('masking.ajax');
        Route::resource('masking', JnsMaskingController::class);

        Route::get('prefix/index-ajax',[JnsPrefixController::class,'indexAjax'])->name('prefix.ajax');
        Route::resource('prefix', JnsPrefixController::class);

        Route::get('privilege/index-ajax',[JnsPrivilegeController::class,'indexAjax'])->name('privilege.ajax');
        Route::resource('privilege', JnsPrivilegeController::class);

        Route::get('tokenbalance/index-ajax',[JnsTokenBalanceController::class,'indexAjax'])->name('tokenbalance.ajax');
        Route::resource('tokenbalance', JnsTokenBalanceController::class);

        Route::get('tokenmap/index-ajax',[JnsTokenMapController::class,'indexAjax'])->name('tokenmap.ajax');
        Route::resource('tokenmap', JnsTokenMapController::class);

        Route::get('watemplate/index-ajax',[JnsWaTemplateController::class,'indexAjax'])->name('watemplate.ajax');
        Route::resource('watemplate', JnsWaTemplateController::class);

        Route::resource('drcategory', DrCategory::class);

        Route::resource('privilegetype', PrivilegeTypeController::class);

    });
    //M2m
    Route::prefix('/m2m')->group(function () {
        Route::get('user/index-ajax',[M2mUserController::class,'indexAjax'])->name('user.ajax');
        Route::resource('user', M2mUserController::class);
    });

    Route::prefix('/smpp')->group(function () {
        Route::get('user/index-ajax',[SmppUserController::class,'indexAjax'])->name('user.ajax');
        Route::resource('user', SmppUserController::class);
    });

    Route::prefix('/wai')->group(function () {
        Route::get('user/index-ajax',[WaiUSerController::class,'indexAjax'])->name('user.ajax');
        Route::resource('user', WaiUSerController::class);
        Route::resource('webhook', WebhookController::class);
        Route::resource('sender', senderControlller::class);
    });
    //PCT
    Route::prefix('/pct')->group(function () {
        Route::get('division/test/createjns',[PctDivisionController::class,'testJnsApi'])->name('division.test.createjns');
        Route::get('division/test/createwa',[PctDivisionController::class,'testWaApi'])->name('division.test.createwa');
        Route::resource('division', PctDivisionController::class);
        Route::get('client/all',[PctClientController::class,'indexAll'])->name('client.all');
        Route::resource('client', PctClientController::class);
        Route::resource('owner', PctDivisionOwner::class);
    });
    Route::prefix('/report')->group(function () {
        Route::prefix('/cpro')->group(function () {
            Route::get('/broadcast-list',[ReportCpro::class,'broadcastList']);
            Route::get('/helpdesk-list',[ReportCpro::class,'helpdeskList']);
           // Route::get('/chatbot-list',[ReportCpro::class,'chatbotList']);
        });
       // Route::get('/wa-push',[WaPushReportController::class,'index']);
        Route::resource('wa-push', WaPushReportController::class);
        Route::resource('sms-push', SmsPushReportController::class);
        Route::post('/request/download',[DownloadController::class,'requestReport']);
        

        //Route::get('/sms-push',[SmsPushReportController::class,'index']);
    });


});







