<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $search=[];
        if(empty($request)){
           // echo 'ok';
            $data= AlertModel::get();
        }else{
         
            if(!empty($request->name)){
                $filter = ['name','=',$request->name];
                array_push($search,$filter);
            }
            if(!empty($request->application)){
                $filter = ['application','=',$request->application];
                array_push($search,$filter);
            }
          //  return $search;
          $data=AlertModel::where($search)->get();
        }
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alert=AlertModel::create([
            'name'=>$request->commonLabels->alertname,
            'application'=>$request->commonLabels->app,
            'message'=>$request->commonAnnotations->summary,
            'raw'=>$request
        ]);
        return $alert;
        
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
