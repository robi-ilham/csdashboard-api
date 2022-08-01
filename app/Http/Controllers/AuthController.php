<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
   
    public function login(Request $request){
       $cred= $request->validate([
            'email'=>'required|email',
            'password'=>[
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);


        if(!Auth::attempt($cred)){
            return response()->json([
                'message'=>'bad credentials'
            ],401);
           
        }
        $user=Auth::user();
        $token = $user->createToken('user')->plainTextToken;
        

       
        $response=[
                'user'=>$user,
                'token'=>$token
        ];
        
        return response()->json($response);
        
    }
    public function register(Request $request){
        $request->validate([
            'name'=>'required|min:4',
            'email'=>'required|email|unique:users',
            'password'=>[
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)

        ]);

        $token = $user->createToken('userToken')->plainTextToken;
        $response=[
                'user'=>$user,
                'token'=>$token
        ];
        
        return response()->json($response);
        
    }

    public function logout(){
       Auth::user()->tokens()->delete();

        return response()->json([
            'message'=>'logged out'
        ]);
    }


}
