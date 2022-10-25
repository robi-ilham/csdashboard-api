<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserContrroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req )
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            'password'=>Hash::make($request->password)

        ]);

        $response=[
                'user'=>$user
        ];
        
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::find($user);
        return response()->json($user,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $user)
    {
        $request->validate([
            'name'=>'required|min:4',
            'email'=>'required|email'
        ]);


        $user=User::findOrFail($user)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'status'=>$request->status
        ]);

        $response=[
                'user'=>$user
        ];
        
        return response()->json($response);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
        ]);
        $user = User::where([
            ['id', '=', $request->id],
            ['password', '=', Hash::make($request->old_password)]
        ])->first();
       print_r($user);
        if ($user) {
            $user->update(['password' => bcrypt($request->password)]);
            return response()->json($user);
        }else{
            return response()->json(['message'=>'user not found'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy( $user)
    {
        $user=User::findOrFail($user)->delete();
        return response()->json(['message'=>'deleted'],200);
    }

    
}
