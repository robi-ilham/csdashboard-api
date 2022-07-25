<?php

namespace App\Http\Controllers;

use App\Models\PctClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PctController extends Controller
{
    public function clientList(){
        $query =  "select * from JTS_CLI_Client";
        $clients = DB::connection('sqlsrv')->select($query);

        $clients = PctClient::paginate();

        return response()->json($clients);
        
    }
}
