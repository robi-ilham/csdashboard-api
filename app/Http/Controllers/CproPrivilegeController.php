<?php

namespace App\Http\Controllers;

use App\Service\CproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CproPrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = CproService::getToken();

        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,401);
        }
        $url = $url=env('CPRO_HOST').'/api/config-sender-combo';
        $headers = ['Authorization'=>$token];
        $body = '{
            "query": {
                "search": "'.$request->search.'",
                "page": '.$request->page.',
                "page-size": 10,
                "order-by": 1,
                "order": "ASC"
            }
        }';
        $response = Http::withHeaders($headers)->withBody($body,'application/json')->post($url)->json();
        return response()->json($response);
    }
}
