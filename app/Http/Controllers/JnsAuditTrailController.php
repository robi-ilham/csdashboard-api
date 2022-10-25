<?php

namespace App\Http\Controllers;

use App\Models\JnsAuditTrail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JnsAuditTrailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JnsAuditTrail::paginate(20);

        return response()->json($data,200);
    }
    public function indexAjax(Request $request)
    {

        // $users= JnsWebUser::with('group')->paginate(5);
        $search=[];
        if(empty($request)){
           // echo 'ok';
            $audit= JnsAuditTrail::get();
        }else{
            $audit=JnsAuditTrail::with('user');
            if(!empty($request->model)){
                $filter = ['model','like','%'.$request->model.'%'];
                array_push($search,$filter);
            }
            // if(!empty($request->group_id)){
            //     $filter = ['group_id','=',$request->group_id];
            //     array_push($search,$filter);
            // }
            if(!empty($request->client_id)){
                $audit=$audit->whereRelation('user', 'client_id', '=',$request->client_id);
            }
            if(!empty($request->division_id)){
                $audit=$audit->whereRelation('user', 'division_id', '=',$request->division_id);
            }
            if(!empty($request->event)){
                $filter = ['event','=',$request->event];
                array_push($search,$filter);
            }
            if(!empty($request->start_date)){
                $filter = ['created','>=',$request->start_date];
                array_push($search,$filter);
            }
            if(!empty($request->end_date)){
                $filter = ['created','<=',$request->end_date];
                array_push($search,$filter);
            }
          //  return $search;
            $audit= $audit->where($search)->get();
        }
        return response()->json($audit,200);
        // $divisions = M2mUser::paginate(20);

        // return response()->json($divisions);
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
