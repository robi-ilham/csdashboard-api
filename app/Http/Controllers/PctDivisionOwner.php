<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PctDivisionOwner extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $today=date('Y-m-d');
       // return $request;
        $data = DB::connection('sqlsrv')->table('JTS_CLI_HistoryARMClient')
                ->select('JTS_CLI_HistoryARMClient.iARMId','JTS_GEN_ARM.szARMName')
                ->distinct()
                ->join('JTS_GEN_ARM','JTS_CLI_HistoryARMClient.iARMId','=','JTS_GEN_ARM.iId')
               ->where('dtmDateEffectiveEnd',null)
                ->where('JTS_CLI_HistoryARMClient.iClientId',$request->id)
                ->orWhere(function($query) use($today){
                    $query->where('dtmDateEffectiveStart','>=',$today)
                    ->where('dtmDateEffectiveEnd','<=',$today);
                })
                ->get();
        return $data;
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
