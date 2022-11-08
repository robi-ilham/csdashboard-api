<?php

namespace App\Http\Controllers;

use App\Models\BroadcastPrivilegeType;
use Illuminate\Http\Request;

class PrivilegeTypeController extends Controller
{
    public function index(){
        $data = BroadcastPrivilegeType::get();
        return response()->json($data);
    }
}
