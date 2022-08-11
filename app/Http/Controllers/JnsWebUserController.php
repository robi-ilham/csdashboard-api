<?php

namespace App\Http\Controllers;

use App\Models\JnsWebUser;
use Illuminate\Http\Request;

class JnsWebUserController extends Controller
{
    public function index(){
        $users= JnsWebUser::paginate();

        return response()->json($users,200);
    }

    public function store(Request $request){
        $request->validate([
            'username'=>'required|string',
            'password'=>'required|confirmed|min:8',
            'name'=>'required',
        ]);

        $user = JnsWebUser::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>sha1($request->password),
            'email'=>$request->email,
            'status'=>1,
            'expiry_mode_id'=>1,
            'group_id'=>$request->group_id,
            'client_id'=>$request->client_id,
            'division_id'=>$request->division_id,
            'use_sha256'=>0
        ]);

        return response()->json($user);
    }
    public function show($id)
    {
        $division=JnsWebUser::find($id);
        return response()->json($division,200);
    }

    public function update(Request $request,$id){
        $request->validate([
            'username'=>'required|string',
            'name'=>'required',
        ]);

        $user = JnsWebUser::findOrFail($id)->update([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>$request->password,
            'email'=>$request->email,
            'status'=>1,
            'expiry_mode_id'=>1,
            'group_id'=>$request->group_id,
            'client_id'=>$request->client_id,
            'division_id'=>$request->division_id,
            'use_sha256'=>0
        ]);

        return response()->json($user);
    }

    public function destroy($user){
        $user = JnsWebUser::findOrFail($user);
        $user->delete();
        return response()->json(['message'=>'data successfully deleted',200]);
    }
}
