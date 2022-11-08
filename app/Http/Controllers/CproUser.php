<?php

namespace App\Http\Controllers;

use App\Models\CstoolAudit;
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

    public function index(Request $request){
        //return $request;
        $page=isset($request->page)?$request->page:1;
        $client_id=isset($request->client_id)?$request->client_id:0;
        $division_id=isset($request->division_id)?$request->division_id:0;
        $username=$request->username;
        $sender=$request->sender_id;
        $group_id=isset($request->privilege_id)?$request->privilege_id:0;


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
                    "client-id": '.$client_id.',
                    "division-id": '.$division_id.',
                    "sender-id": [
                        "'.$sender.'"
                    ],
                    "username": "'.$username.'",
                    "group-id": '.$group_id.'
                },
                "page": '.$page.',
                "page-size": 10,
                "order-by": 1,
                "order": "ASC"
            }
        }';
        //return $body;
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
        $url = $url=env('CPRO_HOST').'/api/user-create-account';
        $headers = ['Authorization'=>$token];
        $params = [
            'username'=>$request->username,
            'password'=>$request->password,
            'client-id'=>$request->client_id,
            'division-id'=>$request->division_id,
            'full-name'=>$request->name,
            'privilege-id'=>$request->privilege_id,
            'sender-id'=>$request->sender_id
        ];
        $this->storeAudit("CREATE",json_encode($params));
        $response = Http::asForm()->withHeaders($headers)->post($url,$params)->json();
        
        return response()->json($response);
    }

    public function resetPassword(Request $request){
        $token = $this->auth();
        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,403);
        }
        $url = $url=env('CPRO_HOST').'/api/users-reset-password';
        $headers = ['Authorization'=>$token];
        $params = [
            'username'=>$request->username,
            'newpassword'=>$request->newpassword,
            
        ];
        $this->storeAudit("RESET PASSWORD",json_encode($params));
        $response = Http::withHeaders($headers)->post($url,$params)->json();
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
        $this->storeAudit("DELETE",json_encode($params));
        $response = Http::withHeaders($headers)->post($url,$params)->json();


        
        return response()->json($response);
    }

    private function storeAudit($type,$json){
        $user=auth()->user();
        $audit=new CstoolAudit();
        $audit->appname='CPRO';
        $audit->type=$type;
        $audit->json=$json;
        $audit->created_by=$user->id;
        $audit->save();

    }
}
