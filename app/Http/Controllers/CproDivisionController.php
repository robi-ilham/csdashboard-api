<?php

namespace App\Http\Controllers;

use App\Models\CproDivision;
use App\Service\CproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CproDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = CproDivision::paginate(20);

        return response()->json($divisions);
    }
    public function indexAll()
    {
        $divisions = CproDivision::all();

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

        $division = CproDivision::create([
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
        $division=CproDivision::find($id);
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

        $division = CproDivision::find($id)->update([
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
        $division=CproDivision::find($id);
        $division->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
