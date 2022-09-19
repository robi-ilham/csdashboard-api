<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;

class CproService{
    public static function getToken(){
        $url=env('CPRO_HOST').'/api/user-login';
        $response=Http::withHeaders(['Authorization'=>"Basic b3BlcmFzaW9uYWw6MTIzNDU2"])->post($url);
        if($response->successful()){
            return $response['users'][0]['token'];
        }
        return false;
    }
}