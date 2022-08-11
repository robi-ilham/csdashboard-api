<?php

namespace App\Http\Controllers;

use App\Models\JnsBroadcastClient;
use App\Models\JnsBroadcastDivision;
use App\Models\M2mUser;
use Illuminate\Http\Request;

class M2mUserController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = M2mUser::paginate(20);

        return response()->json($divisions);
    }
    public function indexAll()
    {
        $divisions = M2mUser::all();

        return response()->json($divisions);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'username'=>'required'
        ]);
        $client = JnsBroadcastClient::find($request->client_id);
        $division = JnsBroadcastDivision::find($request->division_id);
        $data = M2mUser::create([
            'client_name'=>$client->name,
            'client_id'=>$request->client_id,
            'division_id'=>$request->division_id,
            'division_name'=>$division->name,
            'access_mod'=>$this->getAccessMode($request->access_mode),
            'api_key'=>$request->api_key,
            'username'=>$request->username,
            'password'=>$request->password,
            'expiry'=>300,
            'unbillable_access'=>0

        ]);

        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $division=M2mUser::find($id);
        return response()->json($division,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username'=>'required'
        ]);
        dd($request);
        $division = M2mUser::findOrFail($id)->update([
            'client_name'=>$request->client_name,
            'client_id'=>$request->client_id,
            'division_id'=>$request->division_id,
            'division_name'=>$request->division_name,
            'access_mode'=>$this->getAccessMode($request->access_mode),
            'api_key'=>$request->api_key,
            'username'=>$request->username,
            'password'=>$request->password,
            'expiry'=>300,
            'unbillable_access'=>0


        ]);

        return response()->json($division,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $division=M2mUser::find($id);
        $division->delete();
        return response()->json(['message'=>'deleted'],200);
    }
    private function getAccessMode($types){
        $total=0;
        foreach ($types as $val){
            $total=$total+$val;
        }
        return $total;
    }
}
