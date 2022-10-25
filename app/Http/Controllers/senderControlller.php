<?php

namespace App\Http\Controllers;

use App\Models\Sender;
use Illuminate\Http\Request;

class senderControlller extends Controller
{
    public function index(){
        $data = Sender::get();
        return response()->json($data,200);
    }
}
