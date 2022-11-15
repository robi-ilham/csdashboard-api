<?php

namespace App\Http\Controllers;

use App\Service\CproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CproTemplate extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client_id = (isset($request->client_id)&&!empty($request->client_id))?$request->client_id:0;
        $sender_id = (isset($request->sender_id)&&!empty($request->client_id))?$request->sender_id:"";
        $param='{
            "query": {
                "search": {
                    "client-id": '.$client_id.',
                    "sender-id": "'.$sender_id.'",
                    "template-id": 0,
                    "template-type": "",
                    "media-type": "",
                    "template-name": "",
                    "template-status": -1
                },
                "page": 1,
                "page-size": 1000,
                "order-by": 6,
                "order": "DESC"
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
        $url = $url=env('CPRO_HOST').'/api/config-hsmtemplate-list';
        $headers = ['Authorization'=>$token];
        
        $response = Http::withHeaders($headers)->withBody($param,'application/json')->post($url)->json();
        return $response;
    }

    public function list(Request $request)
    {
        $client_id = (isset($request->client_id)&&!empty($request->client_id))?$request->client_id:0;
        $sender_id = (isset($request->sender_id)&&!empty($request->client_id))?$request->sender_id:"";
        $param='{
            "query": {
                "search": {
                    "client-id": '.$client_id.',
                    "sender-id": "'.$sender_id.'",
                    "template-id": 0,
                    "template-type": "",
                    "media-type": "",
                    "template-name": "",
                    "template-status": -1
                },
                "page": 1,
                "page-size": 10,
                "order-by": 6,
                "order": "DESC"
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
        $url = $url=env('CPRO_HOST').'/api/config-hsmtemplate-list';
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
        //
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
