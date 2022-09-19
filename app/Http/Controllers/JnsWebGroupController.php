<?php

namespace App\Http\Controllers;

use App\Models\JnsWebGroup;
use Illuminate\Http\Request;

class JnsWebGroupController extends Controller
{
    public function index(){
        $groups=JnsWebGroup::all();

        return response()->json($groups,200);
    }

    public function store(Request $request){
       
    }
    public function show($id)
    {
        
    }

    public function update(Request $request,$id){
        
    }

    public function destroy($user){
        
    }
}
