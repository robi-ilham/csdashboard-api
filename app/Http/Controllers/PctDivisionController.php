<?php

namespace App\Http\Controllers;

use App\Models\PctCliClientMasking;
use App\Models\PctClientConfig;
use App\Models\PctClientConfigPrepaid;
use App\Models\PctClientDivision;
use App\Models\PctCliHistoryArmClient;
use App\Models\PctSyncClientMappingWa;
use App\Models\PctSyncMappingClient;
use App\Models\PctSyncMappingDivision;
use App\Models\PctSynMappingDivisionWa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PctDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return $request;
        $data =PctClientDivision::select('*');
        if(!empty($request->client_id)){
            $data->where('iCLientId',$request->client_id);
        }
        if(!empty($request->division_name)){
            $data->where('szDivision','like','%'.$request->division_name.'%');
        }
        
        $data = $data->paginate(10);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $client_id = $request->client_id;
        $tokenType = $request->token_type;
        $baType = $request->ba_type;
        $iArmId = $request->i_arm_id;
        $divisionName=$request->division_name;

        $division = new PctClientDivision();
        $division->iClientid = $client_id;
        $division->szDivision = $divisionName;
        $division->szInsertedby = $user->name;
        $division->bActive = 1;
        $division->save();
        $division_id = $division->iId;

        $syncMappingDivision = new PctSyncMappingDivision();
        $syncMappingDivision->iDivisionId = $division_id;
        $tokenText=[
            0=>'postpaid',
            1=>'prepaidbyclient',
            2=>'prepaidbydivision'
        ];

        if ($request->broadcast) {


            $syncMappingClient = PctSyncMappingClient::where('iClientId', $client_id)->first();
            if ($syncMappingClient->iClientJNS6Id != null) {
                //hit api create jns
                $create=Http::get(env('CREATE_DIVISION_JNS_URL'), [
                    'clientid' => $client_id,
                    'divisionname' => $divisionName,
                    'tokentype'=>$tokenText[$tokenType],
                    'batype'=>$tokenText[$baType]
                ]);
               // print_r($create);
                $syncMappingDivision->iDivisionJNS6Id = $division_id;
            }


            if ($tokenType == 1) {
                $clientConfig = PctClientConfig::where('iClientId', $client_id)->first();

                $clientConfigPrepaid = PctClientConfigPrepaid::where('iId', $clientConfig->iId)->first();

                if ($clientConfigPrepaid) {
                    $configPrepaid = new PctClientConfigPrepaid();
                    $configPrepaid->itemNumber = $clientConfigPrepaid->itemNumber + 1;
                    $configPrepaid->iDivisionId = $division_id;
                    $configPrepaid->save();
                }
            }
        }


        $syncMappingDivision->save();

        $jtsSyncMappingDivisionWA = new PctSynMappingDivisionWa();
        $jtsSyncMappingDivisionWA->iDivisionId = $division_id;
        $jtsSyncMappingDivisionWA->iDivisionJNS6Id = $division_id;
        $jtsSyncMappingDivisionWA->save();


        if ($request->wa) {
            $jtsSyncMappingClientWa = PctSyncClientMappingWa::where('iClientId', $client_id)->first();
            $client_id_jns = $jtsSyncMappingClientWa->iClientJNS6Id;
            $payload = '{
                "id":' . $client_id . ',
                "name":"' . $division->szDivision . '",
                "clientId":' . $client_id_jns . '
            }';

            $response = Http::withBody($payload, 'application/json')->post(env('CREATE_DIVISION_WA_URL'))->json();
        }

        $clientMasking = PctCliClientMasking::where('iClientId', $client_id)->first();
        $today = date('Y-m-d');
        $total = PctCliHistoryArmClient::where('iClientId', $client_id)
            ->where('dtmDateEffectiveEnd', null)
            ->orWhere(function ($query) use ($today) {
                $query->where('dtmDateEffectiveStart', '>=', $today)
                    ->where('dtmDateEffectiveEnd', '<=', $today);
            })->get();
        $iTotal = $total->count();
        if ($iTotal > 0 && $request->broadcast) {

            $jtsCliHistoryArmClient = new PctCliHistoryArmClient();
            $jtsCliHistoryArmClient->dtmDateEffectiveStart = date('Y-m-d');
            $jtsCliHistoryArmClient->iArmId = $iArmId;
            $jtsCliHistoryArmClient->iProductId = 1;
            $jtsCliHistoryArmClient->iClientId = $client_id;
            $jtsCliHistoryArmClient->iDivisionId = $division_id;
            $jtsCliHistoryArmClient->iOtherId = $clientMasking->iMaskingId;
            $jtsCliHistoryArmClient->szInsertedBy=$user->name;
            $jtsCliHistoryArmClient->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $division_id=$request->division_id;
        $client_id = $request->client_id;
        $tokenType = $request->token_type;
        $baType = $request->ba_type;
        $iArmId = $request->i_arm_id;
        $divisionName=$request->division_name;
        $tokenText=[
            0=>'postpaid',
            1=>'prepaidbyclient',
            2=>'prepaidbydivision'
        ];

        //update division;
        $division=PctClientDivision::find($division_id);
        $division->iClientid = $client_id;
        $division->szDivision = $divisionName;
        $division->szUpdatedBy = $user->name;
        $division->bActive = 1;
        $division->save();

        $jtsSyncMappingClientWa=PctSyncClientMappingWa::where('iClientId',$client_id)->first();
        $jtsSyncMappingDivisionWA=PctSynMappingDivisionWa::where('iDivisionId',$division_id)->first();

        $iClientIdJns=$jtsSyncMappingClientWa->iCLientJNS6Id;
        $iDivisionIdJns = $jtsSyncMappingDivisionWA->iDivisionJns6Id;

        if($request->wa && $jtsSyncMappingClientWa && $jtsSyncMappingDivisionWA){
            
            if(empty($iDivisionIdJns)){
                $payload = '{
                    "id":' . $client_id . ',
                    "name":"' . $division->szDivision . '",
                    "clientId":' . $iClientIdJns . '
                }';
    
                $response = Http::withBody($payload, 'application/json')->post(env('CREATE_DIVISION_WA_URL'))->json();
    
                $SyncMappingDivisionWA = new PctSynMappingDivisionWa();
                $SyncMappingDivisionWA->iDivisionId = $division->iId;
                $SyncMappingDivisionWA->iDivisionJNS6Id = $division->iId;
                $SyncMappingDivisionWA->save();
            }else{
                $payload = '{
                    "id":' . $client_id . ',
                    "name":"' . $division->szDivision . '",
                    "clientId":' . $iClientIdJns . '
                }';
    
                $response = Http::withBody($payload, 'application/json')->post(env('UPDATE_DIVISION_WA_URL'))->json();
            }
            


        }else{
            $payload = '{
                "id":' . $client_id . ',
                "name":"' . $division->szDivision . '",
                "clientId":' . $iClientIdJns . '
            }';

            $response = Http::withBody($payload, 'application/json')->post(env('CREATE_DIVISION_WA_URL'))->json();

            $SyncMappingDivisionWA = new PctSynMappingDivisionWa();
            $SyncMappingDivisionWA->iDivisionId = $division->iId;
            $SyncMappingDivisionWA->iDivisionJNS6Id = $division->iId;
            $SyncMappingDivisionWA->save();
        }

        $jtsSyncMappingClient=PctSyncMappingClient::where('iClientId',$client_id);
        $jtsSyncMappingDivision=PctSyncMappingDivision::where('iDivisionId',$division_id);

        $iclientid=$jtsSyncMappingClient->iClientId;
        $iDivisionId=$jtsSyncMappingDivision->iDivisionId;

        if($request->broadcast && $jtsSyncMappingClient && $jtsSyncMappingDivision){
            $update=Http::get(env('UPDATE_DIVISION_JNS_URL'), [
                'clientid' => $client_id,
                'newdivisionname' => $divisionName,
                'divisionid'=>$division_id
                
            ]);

        }else{
            $iClientIdJns=$jtsSyncMappingClient->iClientJNS6Id;
            if(!empty($iClientIdJns)){
                $create=Http::get(env('CREATE_DIVISION_JNS_URL'), [
                    'clientid' => $client_id,
                    'divisionname' => $divisionName,
                    'tokentype'=>$tokenText[$tokenType],
                    'batype'=>$tokenText[$baType]
                ]);
            }
            $syncMappingDivision = new PctSyncMappingDivision();
            $syncMappingDivision->iDivisionId = $division_id;
            $syncMappingDivision->iDivisionJNS6Id=$division_id;
            $syncMappingDivision->save();
            if($tokenType==1){
                $jtsCLiClientConfig=PctClientConfig::where('iClientId',$client_id)->first();
                $iConfigId=$jtsCLiClientConfig->iId;
                $jtsCliClientConfigPrepaidDivision=PctClientConfigPrepaid::where('iId',$iConfigId);
                if(!empty($jtsCliClientConfigPrepaidDivision->iId)){
                    $configPrepaid = new PctClientConfigPrepaid();
                    $configPrepaid->itemNumber = $jtsCliClientConfigPrepaidDivision->itemNumber + 1;
                    $configPrepaid->iDivisionId = $division_id;
                    $configPrepaid->save();
                }
            }

        }





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
