<?php

namespace App\Http\Controllers;

use App\Models\JnsBroadcastClient;
use App\Models\JnsBroadcastDivision;
use App\Models\JnsMasking;
use App\Models\WAPushReport;
use Illuminate\Http\Request;

class WaPushReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = [];
        if (empty($request)) {
            $data = WAPushReport::orderBy('created','desc')->paginate(10);
        } else {
            $data=WAPushReport::select('*');
            if (!empty($request->client_id)) {
                $filter = ['client_id', '=', $request->client_id];
                array_push($search, $filter);
            }
            if (!empty($request->division_id)) {
                $filter = ['division_id', '=', $request->division_id];
                array_push($search, $filter);
            }
            if (!empty($request->status)) {
                $filter = ['process_status', '=', $request->status];
                array_push($search, $filter);
            }
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $filter = ['process_status', '=', $request->status];
                array_push($search, $filter);
                $data=$data->whereBetween('created',[$request->start_date,$request->end_date]);
            }
            
            
            $data = $data->where($search)->orderBy('created','desc')->paginate(10);
        }
        return response()->json($data, 200);
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
        $division_id = empty($request->division_id) ? 0 : $request->division_id;
        $division = JnsBroadcastDivision::find($division_id);
        $division_name = empty($request->division_id) ? 'all' : $division->name;

        $client_id = $request->client_id;
        $client = JnsBroadcastClient::find($client_id);
        $client_name = empty($request->client_id) ? 'all' : $client->name;

        $mask_id = empty($request->mask_id) ? 0 : $request->mask_id;
        $mask = JnsMasking::find($mask_id);
        $mask_name = empty($request->mask_id) ? 'all' : $mask->name;

        $batchname = empty($request->batchname) ? 'all' : $request->batchname;
        $msisdn = empty($request->msisdn) ? 'all' : $request->msisdn;
        $month = $request->day;
        $day = $request->month;
        $year = $request->year;

        $insert = [
            'division_id' => $division_id,
            'division_name' => $division_name,
            'client_id' => $client_id,
            'client_name' => $client_name,
            'request_day' => $day,
            'request_month' => $month,
            'request_year' => $year
        ];

        $create = WAPushReport::create($insert);



        $spec = '{"command":"report-request-wa",
            "clientName":"' . $client_name . '",
            "clientId":' . $client_id . ',
            "data":{"divisionId":"' . $division_id . '",
                "divisionName":"' . $division_name . '",
                "maskId":"' . $mask_id . '","maskName":"' . $mask_name . '",
                "batchname":"' . $batchname . '",
                "msisdn":"' . $msisdn . '","requestedMonth":"' . $month . '","requestedYear":"' . $year . '","requestedDay":"' . $day . '","requestId":"' . $create->id . '"}}';


        $update = WAPushReport::find($create->id);
        $update->request_spec = $spec;
        $update->save();

        return $update;
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
    public function download(Request $request)
    {
        $id = $request->id;
        $data = WAPushReport::find($id);

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($data->client_name) . ".csv\"");
        readfile($data->output);
        exit;
    }
}
