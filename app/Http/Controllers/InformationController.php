<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
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
            $data= Information::get();
        }else{
            if(!empty($request->name)){
                $filter = ['name','like','%'.$request->name.'%'];
                array_push($search,$filter);
            }
            if(!empty($request->information)){
                $filter = ['information','like','%'.$request->information.'%'];
                array_push($search,$filter);
            }

            if(!empty($request->created_at)){
                $filter = ['date(created_at)','=',$request->created_at];
                array_push($search,$filter);
            }
           
            //return $search;
            $data = Information::where($search)->get();
        }
        return response()->json($data,200);
       ;
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
        $store = Information::create([
            'name'=>$request->name,
            'information'=>$request->information,
            'created_by'=>Auth::user()->id
        ]);
        return $store;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Information::find($id);
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
        $store = Information::findOrFail($id)->update([
            'name'=>$request->name,
            'information'=>$request->information,
            
        ]);
        return response()->json($store,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy= Information::findOrFail($id);
        return $destroy->delete();
    }
}
