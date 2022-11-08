<?php

namespace App\Http\Controllers;

use App\Service\CproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CproHelpdeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $client=empty($request->client_id)?0:$request->client_id;
        $division=empty($request->division_id)?0:$request->division_id;
        $startDate=empty($request->start_date)?'':$request->start_date;
        $endDate=empty($request->end_date)?'':$request->end_date;
        $param='{
            "query": {
                "search": {
                    "client-id": '.$client.',
                    "division-id": '.$division.',
                    "status": 0,
                    "start-date": "'.$startDate.'",
                    "end-date": "'.$endDate.'"
                },
                "page": 1,
                "page-size": 10,
                "order-by": 2,
                "order": "DESC"
            }
        }';

      //  return $param;
        $token = CproService::getToken();

        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,401);
        }
        $url = $url=env('CPRO_HOST').'/api/report-helpdesk-list';
        $headers = ['Authorization'=>$token];
        
        $response = Http::withHeaders($headers)->withBody($param,'application/json')->post($url)->json();
        return $response;
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
        $client=empty($request->client_id)?0:$request->client_id;
        $division=empty($request->division_id)?0:$request->division_id;
        $sender=empty($request->sender)?0:$request->sender;
        $startDate=empty($request->start_date)?'':$request->start_date." 00:00:00";
        $endDate=empty($request->end_date)?'':$request->end_date." 23:59:59";
        $msisdn=empty($request->msisdn)?'':$request->msisdn;
        $ticket_no=empty($request->ticket_no)?'':$request->ticket_no;
        $spv_name=empty($request->spv_name)?'':$request->spv_name;
        $template=empty($request->template)?'':$request->template;

        $param='{
            "filter": {
                "spv-name": "'.$spv_name.'",
                "client-id": '.$client.',
                "division-id": '.$division.',
                "sender-id": "'.$sender.'",
                "template-id": "'.$template.'",
                "start-date": "'.$startDate.'",
                "end-date": "'.$endDate.'",
                "msisdn": "'.$msisdn.'",
                "ticket-no": "'.$ticket_no.'",
                "cs-id": "",
                "spv-id": "",
                "priority-id": "",
                "category-id": "",
                "status": "open"
            }
        }';
        $token = CproService::getToken();

        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,401);
        }
        $url = $url=env('CPRO_HOST').'/api/report-helpdesk-request';
        $headers = ['Authorization'=>$token];
        
        $response = Http::withHeaders($headers)->withBody($param,'application/json')->post($url)->json();
        return $response;
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
        //
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
