<?php

namespace App\Http\Controllers;

use App\Models\JnsMasking;
use Illuminate\Http\Request;

class JnsMaskingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JnsMasking::paginate(20);

        return response()->json($data);
    }
    public function indexAjax(Request $request)
    {
    
        $search=[];
        if(empty($request)){
           // echo 'ok';
            $word= JnsMasking::get();
        }else{
            
            $word = JnsMasking::with('clients');
            if(!empty($request->client_id)){
                
                $word=$word->whereRelation('clients', 'client_id', '=',$request->client_id);
            }
            if(!empty($request->masking)){
                $filter = ['name','like','%'.$request->masking.'%'];
                array_push($search,$filter);
                $word=$word->where($search);
            }
          //  return $search;
           return $word->get();
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
