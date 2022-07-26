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

    public function create(Request $request){
        $request->validate([
            'username'=>'required|string',
            'password'=>'required',
            'name'=>'required',
            'email'=>'required',
        ]);

        $user = JnsWebUser::create([
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
    public function detail(Request $request){

        $request->validate([
            'id'=>'required|integer'
        ]);

        $user = JnsWebUser::find($request->id);

        return response()->json($user);
    }

    public function update(Request $request){
        $request->validate([
            'username'=>'required|string',
            'password'=>'required',
            'name'=>'required',
            'email'=>'required',
        ]);

        $user = JnsWebUser::where('id',$request->id)->update([
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

    public function delete(Request $request){
        $user = JnsWebUser::find($request->id);
        $user->delete();
        return response()->json(['message'=>'data successfully deleted',200]);
    }
}
