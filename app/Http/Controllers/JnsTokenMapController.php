<?php

namespace App\Http\Controllers;

use App\Models\JnsTokenMap;
use Illuminate\Http\Request;

class JnsTokenMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JnsTokenMap::paginate(20);

        return response()->json($data);
    }
    public function indexAjax(Request $request)
    {
    
        $search=[];
        if(empty($request)){
           // echo 'ok';
            $word= JnsTokenMap::paginate(10);
        }else{
            if(!empty($request->account_no)){
                $filter = ['account_no','like','%'.$request->account_no.'%'];
                array_push($search,$filter);
            }
            if(!empty($request->charge_code)){
                $filter = ['charge_code','like','%'.$request->charge_code.'%'];
                array_push($search,$filter);
            }
            if(!empty($request->client_id)){
                $filter = ['client_id','=',$request->client_id];
                array_push($search,$filter);
            }
            if(!empty($request->division_id)){
                $filter = ['client_id','=',$request->division_id];
                array_push($search,$filter);
            }
            
            $word = JnsTokenMap::where($search)->paginate(10);
        }
        return response()->json($word,200);
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
