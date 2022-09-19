<?php

namespace App\Http\Controllers;

use App\Models\JnsWebUser;
use Illuminate\Http\Request;

class JnsWebUserController extends Controller
{
    public function index(Request $request){
        $users= JnsWebUser::paginate();
        $search=[];
        if(empty($request)){
            $users= JnsWebUser::paginate();
        }else{
            if(!empty($request->username)){
                $filter = ['username','like','%'.$request->username.'%'];
                array_push($search,$filter);
            }
            if(!empty($request->group_id)){
                $filter = ['group_id','=',$request->username];
                array_push($search,$filter);
            }
            if(!empty($request->client_id)){
                $filter = ['group_id','=',$request->client_id];
                array_push($search,$filter);
            }
            if(!empty($request->division_id)){
                $filter = ['group_id','=',$request->division_id];
                array_push($search,$filter);
            }
            //return $search;
            $users = JnsWebUser::where($search)->paginate();
        }
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
            'expiry_mode_id'=>$request->expiry_mode_id,
            'expiry'=>$request->expiry,
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
            'expiry_mode_id'=>$request->expiry_mode_id,
            'expiry'=>$request->expiry,
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
    public function resetPassword($request,$id){
        $request->validate([
            'password'=>'required|confirmed|min:8',
        ]);
        $user = JnsWebUser::findOrFail($id)->update([
           
            'password'=>sha1($request->password),
           
        ]);

        return response()->json($user);
    }
}
