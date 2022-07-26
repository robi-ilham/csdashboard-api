<?php

namespace App\Http\Controllers;

use App\Models\JnsBroadcastDivision;
use Illuminate\Http\Request;

class JnsBroadcastDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = [];
        if (empty($request)) {
            // echo 'ok';
            $users = JnsBroadcastDivision::paginate(10);
        } else {
            
            if (!empty($request->client_id)) {
                $filter = ['client_id', '=', $request->client_id];
                array_push($search, $filter);
            }
            if (!empty($request->name)) {
                $filter = ['name', 'like', '%'.$request->name.'%'];
                array_push($search, $filter);
            }
            
            $users = JnsBroadcastDivision::where($search)->paginate(10);
        }
        return response()->json($users, 200);
        
    }
    public function indexAll(Request $request)
    {
        $search = [];
        if (empty($request)) {
            // echo 'ok';
            $divisions = JnsBroadcastDivision::get();
        } else {
            
            if (!empty($request->client_id)) {
                $filter = ['client_id', '=', $request->client_id];
                array_push($search, $filter);
            }
            if (!empty($request->name)) {
                $filter = ['name', 'like', '%'.$request->name.'%'];
                array_push($search, $filter);
            }
            if (!empty($request->q)) {
                $filter = ['name', 'like', '%'.$request->q.'%'];
                array_push($search, $filter);
            }
           
            $divisions = JnsBroadcastDivision::where($search)->get();
        }
        return response()->json($divisions);
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
            'name'=>'required'
        ]);

        $division = JnsBroadcastDivision::create([
            'name'=>$request->name,
            'client_id'=>$request->client_id
        ]);

        return response()->json($division,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $division=JnsBroadcastDivision::find($id);
        return response()->json($division,200);
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
        $request->validate([
            'name'=>'required'
        ]);

        $division = JnsBroadcastDivision::find($id)->update([
            'name'=>$request->name,
            'client_id'=>$request->client_id
        ]);

        return response()->json($division,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $division=JnsBroadcastDivision::find($id);
        $division->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
