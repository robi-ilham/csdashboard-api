<?php

namespace App\Http\Controllers;

use App\Models\JnsTokenBalance;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;

class JnsTokenBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JnsTokenBalance::paginate(20);

        return response()->json($data);
    }
    public function indexAjax(Request $request)
    {
    
        $search=[];
        if(empty($request)){
           // echo 'ok';
            $data= JnsTokenBalance::get();
        }else{
            $data=JnsTokenBalance::with('mapgroup');
         
            if(!empty($request->client_id)){
               $data=$data->whereHas('mapgroup.tokenmap',function(EloquentBuilder $query) use ($request){
                $query->where('client_id','=',$request->client_id);
               });
            }
            if(!empty($request->division_id)){
                $data=$data->whereHas('mapgroup.tokenmap',function(EloquentBuilder $query) use ($request){
                    $query->where('division_id','=',$request->division_id);
                   });
             }
          //  return $search;
            $data = $data->get();
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
