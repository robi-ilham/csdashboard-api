<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CproUser extends Controller
{
    private function auth(){
        $url=env('CPRO_HOST').'/api/user-login';
        $response=Http::withHeaders(['Authorization'=>"Basic b3BlcmFzaW9uYWw6MTIzNDU2"])->post($url);
        if($response->successful()){
            return $response['users'][0]['token'];
        }
        return false;

    }

    public function index(){
        $token = $this->auth();
        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,401);
        }
        $url = $url=env('CPRO_HOST').'/api/user-list';
        $headers = ['Authorization'=>$token];
        $body = '{
            "query": {
                "search": {
                    "client-id": 0,
                    "division-id": 0,
                    "sender-id": [
                        ""
                    ],
                    "username": "",
                    "group-id": 0
                },
                "page": 1,
                "page-size": 10,
                "order-by": 1,
                "order": "ASC"
            }
        }';
        $response = Http::withHeaders($headers)->withBody($body,'application/json')->post($url)->json();
        return response()->json($response);
    }
    public function store(Request $request){
        $token = $this->auth();
        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,403);
        }
        $url = $url=env('CPRO_HOST').'/api/create-account';
        $headers = ['Authorization'=>$token];
        $params = [
            'username'=>$request->username,
            'password'=>$request->password,
            'client-id'=>$request->client_id,
            'division-id'=>$request->divison_id,
            'fullname'=>$request->fullname,
            'privilege-id'=>$request->privilege_id,
            'sender-id'=>$request->sender_id
        ];
        $response = Http::withHeaders($headers)->post($url,$params)->json();
        
        return response()->json($response);
    }

    public function destroy($username){
        $token = $this->auth();
        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,403);
        }
        $url = $url=env('CPRO_HOST').'/api/users-delete-account';
        $headers = ['Authorization'=>$token];
        $params = [
            'username'=>$username,

        ];
        $response = Http::withHeaders($headers)->post($url,$params)->json();
        
        return response()->json($response);
    }
}
