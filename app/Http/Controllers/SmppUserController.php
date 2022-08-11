<?php

namespace App\Http\Controllers;

use App\Models\SmppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmppUserController extends Controller
{
    public function index()
    {
        $data = SmppUser::paginate(20);

        return response()->json($data);
    }
    public function indexAll()
    {
        $data = SmppUser::all();

        return response()->json($data);
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
            'dr_format'=>'required|integer'
        ]);
        $data = SmppUser::create([
            'system_id'=>$request->system_id,
            'client_id'=>$request->client_id,
            'password'=>$request->password,
            'division'=>$request->division,
            'upload_by'=>$request->upload_type,
            'service_type'=>$request->service_type,
            'batchname'=>$request->batchname,
            'use_optional_parameter'=>DB::raw($request->use_optional_parameter),
            'use_expired_session'=>DB::raw($request->use_expired_session),
            'max_connection'=>$request->max_connection,
            'dr_format'=>'int'


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
        $data=SmppUser::find($id);
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
        $data = SmppUser::findOrFail($id)->update([
            'system_id'=>$request->system_id,
            'client_id'=>$request->client_id,
            'password'=>$request->password,
            'division'=>$request->division,
            'upload_type'=>$request->upload_type,
            'service_type'=>$request->service_type,
            'bacthname'=>$request->bacthname,
            'use_optional_parameter'=>$request->use_optional_parameter,
            'use_expired_session'=>$request->use_expired_session,
            'max_connection'=>$request->max_connection,
            'dr_format'=>$request->dr_format


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
        $data=SmppUser::find($id);
        $data->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
