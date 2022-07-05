<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeterReadingRequest;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeterReadingRequest $request)
    {
        $previousReading = MeterReading::where([
            'tenant_id' => $request->tenant_id
        ])->orderBy('id', 'desc')->first();

        $currentReading = MeterReading::create([
            'tenant_id' => $request->tenant_id,
            'initial_reading' => $previousReading->current_reading,
            'current_reading' => $request->current_reading,
        ]); 

        //add this reading to the queue in order to be processed at night

        return response()->json([
            'data' => $currentReading,
            'message' => 'Meter reading recorded. We will send pricing communication to the tenant'
        ]);
    }
}
