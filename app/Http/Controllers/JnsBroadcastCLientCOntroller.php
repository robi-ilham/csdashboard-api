<?php

namespace App\Http\Controllers;

use App\Models\JnsBroadcastClient;
use Illuminate\Http\Request;

class JnsBroadcastCLientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = JnsBroadcastClient::paginate(20);
        return response()->json($clients,200);
    }

    public function indexAll()
    {
        $clients = JnsBroadcastClient::all();
        return response()->json($clients,200);
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
            'code'=>'required',
            'name'=>'required'
        ]);

        $client=JnsBroadcastClient::create([
            'code'=>$request->code,
            'name'=>$request->name,
            'active'=>1,
            'api_key'=>'what is this?'
        ]);

        return response()->json($client,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client=JnsBroadcastClient::find($id);

        return response()->json($client,200);
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
            'code'=>'required',
            'name'=>'required'
        ]);

        $client=JnsBroadcastClient::find($id)->create([
            'code'=>$request->code,
            'name'=>$request->name,
            'active'=>1,
            'api_key'=>'what is this?'
        ]);

        return response()->json($client,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client=JnsBroadcastClient::findOrFail($id);
        $client->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
