<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeterReadingRequest;
use App\Jobs\NotifyTenant;
use App\Models\MeterReading;
use Illuminate\Support\Facades\DB;

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
        $currentReading = DB::transaction(function () use($request) {
            $previousReading = MeterReading::where([
                'tenancy_id' => $request->tenancy_id
            ])->orderBy('id', 'desc')->first();

            $currentReading = MeterReading::create([
                'tenancy_id' => $request->tenancy_id,
                'current_units' => $request->meter_reading,
                'previous_units' => $previousReading->current_units,
            ]); 
    
            NotifyTenant::dispatch($currentReading);

            return $currentReading;
        });

        return response()->json([
            'data' => $currentReading,
            'message' => 'Meter reading recorded. Tenant will be notified'
        ]);
    }
}
