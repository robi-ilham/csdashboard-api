<?php

namespace App\Http\Controllers;

use App\Models\WaiUser;
use Illuminate\Http\Request;

class WaiUSerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WaiUser::paginate(20);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'name'=>'required',
            'username'=>'required',
            'password'=>'required'
        ]);
        $data = WaiUser::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'client_id'=>$request->client_id,
            'password'=>sha1($request->password),
            'division_id'=>$request->division_id,
            'group_id'=>$request->group_id,
            'status'=>'new',
            'counter'=>0,
            'sender_id'=>$request->sender_id


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
        $data=WaiUser::find($id);
        return response()->json($data,200);
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
            'name'=>'required',
            'username'=>'required'
        ]);
        $data = WaiUser::findOrFail($id)->update([
            'name'=>$request->name,
            'username'=>$request->username,
            'client_id'=>$request->client_id,
            'division_id'=>$request->division_id,
            'group_id'=>$request->group_id,
            'status'=>'new',
            'counter'=>0,
            'sender_id'=>$request->sender_id

        ]);

        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=WaiUser::find($id);
        $data->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
