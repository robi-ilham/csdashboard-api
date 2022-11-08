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
    public function index(Request $request)
    {
        $search=[];
        if(empty($request)){
           // echo 'ok';
            $data= AlertModel::get();
        }else{
         $data=AlertModel::select('*');
            if(!empty($request->name)){
                $data=$data->where('name','like','%'.$request->name.'%');
            }
            if(!empty($request->application)){
                $data=$data->where('application','like','%'.$request->application.'%');
            }
            if(!empty($request->created_at)){
                $data=$data->whereDate('created_at', '=', $request->created_at);;
            }
           //return $search;
          $data=$data->get();
        }
        return response()->json($data,200);
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
        // $insert=[
        //     'name'=>$request->commonLabels->alertname,
        //     'application'=>$request->commonLabels->app,
        //     'message'=>$request->commonAnnotations->summary,
        //     'raw'=>$request
        // ];
        foreach($request->alerts as $alert){
            $alertname=$alert['labels']['alertname'];
            $app=$alert['labels']['app'];
            $message = $alert['annotations']['summary'];

            $insert=[
            'name'=>$alertname,
            'application'=>$app,
            'message'=>$message,
            'raw'=>$request
        ];
        $alert=AlertModel::create($insert);
        }
      
        
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
