<?php

namespace App\Http\Controllers;

use App\Service\CproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CproDownloadReport extends Controller
{
    public function summary(Request $request)
    {
        $token = CproService::getToken();

        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,401);
        }
        $request_id = $request->request_id;
        $payload = '
			{
				"request-id":"' . $request_id . '",
				"type":"summary"
			}

        ';
        $response = Http::withHeaders(['Authorization' => $token])->withBody($payload, 'application/json')->post(env('CPRO_REPORT_URL'));

        return $response;
    }

    public function detail(Request $request)
    {
        $token = CproService::getToken();

        if(!$token){
            $response=[
                'status'=>0,
                'message'=>'login cpro failed'
            ];
            return  response()->json($response,401);
        }

        $request_id = $request->request_id;
        $payload = '
			{
				"request-id":"' . $request_id . '",
				"type":"detail"
			}

        ';
       // return env('CPRO_REPORT_URL');
        $response = Http::withHeaders(['Authorization' => $token])->withBody($payload, 'application/json')->post(env('CPRO_REPORT_URL'));

        return $response;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
