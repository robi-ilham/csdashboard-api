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
    public function indexAjax(Request $request){
         $search=[];
         if(empty($request)){
            // echo 'ok';
             $users= SmppUser::get();
         }else{
             if(!empty($request->username)){
                 $filter = ['username','like','%'.$request->username.'%'];
                 array_push($search,$filter);
             }
             if(!empty($request->group_id)){
                 $filter = ['group_id','=',$request->group_id];
                 array_push($search,$filter);
             }
             if(!empty($request->client_id)){
                 $filter = ['client_id','=',$request->client_id];
                 array_push($search,$filter);
             }
             if(!empty($request->division_id)){
                 $filter = ['division_id','=',$request->division_id];
                 array_push($search,$filter);
             }
             //return $search;
             $users = SmppUser::where($search)->get();
         }
         return response()->json($users,200);
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
            'client_id'=>'required|integer',
            'system_id'=>'required'
        ]);
        $data = SmppUser::create([
            'system_id'=>$request->system_id,
            'client_id'=>$request->client_id,
            'password'=>$request->password,
            'division'=>$request->division,
            'upload_by'=>$request->upload_type,
            'service_type'=>$request->service_type,
            'batchname'=>$request->batchname,
            'use_optional_parameter'=>($request->use_optional_parameter==1)?true:false,
            'use_expired_session'=>($request->use_expired_session==1)?true:false,
            'max_connection'=>$request->max_connection,
            'dr_format'=>$request->dr_format


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
        $data=SmppUser::where('client_id',$id)->first();
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
        $data = SmppUser::where('client_id',$id)->update([
            
            'password'=>$request->password,
            'division'=>$request->division,
            'upload_by'=>$request->upload_by,
            'service_type'=>$request->service_type,
            'batchname'=>$request->batchname,
            'use_optional_parameter'=>($request->use_optional_parameter==1)?true:false,
            'use_expired_session'=>($request->use_expired_session==1)?true:false,
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
        $data=SmppUser::where('client_id',$id);
        $data->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
