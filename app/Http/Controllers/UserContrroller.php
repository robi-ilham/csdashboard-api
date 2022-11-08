<?php

namespace App\Http\Controllers;

use App\Models\CstoolAudit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserContrroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = [];
        if (empty($request)) {
            // echo 'ok';
            $users = user::get();
        } else {
            
            if (!empty($request->email)) {
                $filter = ['email', 'like', "%".$request->email."%"];
                array_push($search, $filter);
            }
            if (!empty($request->name)) {
                $filter = ['name', 'like', '%'.$request->name.'%'];
                array_push($search, $filter);
            }
            if (!empty($request->status)) {
                $filter = ['status', '=', $request->status];
                array_push($search, $filter);
            }
            
            $users = User::where($search)->get();
        }
        return response()->json($users, 200);
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
        $this->storeAudit('CREATE',$request);

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
        $user = User::find($user->id);
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
            'status'=>'required'
        ]);


        $user=User::findOrFail($user)->update([
            'status'=>$request->status
        ]);
        $this->storeAudit('UPDATE',$request);

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
        $user=User::find($request->id);
        if($user){
            if(Hash::check($request->password,$user->password)){
                $user->update(['password' => Hash::make($request->password)]);
                $this->storeAudit('RESET PASSWORD',$request);
                return response()->json($user,200);
            }else{
                $error = ValidationException::withMessages(['message'=>'user not found']);
                throw $error;
            }
        }else{
            return response(['message'=>'user not found'],404);
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
        $this->storeAudit('DELETE',$user);
        return response()->json(['message'=>'deleted'],200);
    }

    private function storeAudit($type,$json){
        $user=auth()->user();
        $audit=new CstoolAudit();
        $audit->appname='CSTOOLS';
        $audit->type=$type;
        $audit->json=$json;
        $audit->created_by=$user->id;
        $audit->save();

    }
}
