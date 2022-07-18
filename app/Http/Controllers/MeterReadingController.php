<?php

namespace App\Http\Controllers;

use App\Actions\Billing\Biller;
use App\Http\Filters\MeterReadingFilter;
use App\Http\Requests\MeterReadingRequest;
use App\Http\Resources\MeterReadingResource;
use App\Http\Resources\MeterReadingResourceCollection;
use App\Jobs\NotifyTenant;
use App\Models\Apartment;
use App\Models\MeterReading;
use App\Models\Tenancy;
use Illuminate\Support\Facades\DB;

class MeterReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment)
    {
        $meterReadings = osmose(MeterReadingFilter::class)
            ->whereNotNull('previous_units')
            ->orderBy('id', 'desc')
            ->paginate(15);
        
        return new MeterReadingResourceCollection($meterReadings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeterReadingRequest $request, Apartment $apartment)
    {
        $meterReading = DB::transaction(function () use($request) {
            $tenancy = Tenancy::find($request->tenancy_id);
            $meterReading = $request->meter_reading;

            $biller = new Biller($tenancy, $meterReading);

            $meterReading = MeterReading::create([
                'tenancy_id' => $tenancy->id,
                'current_units' => $meterReading,
                'consumed_units' => $biller->consumption,
                'previous_units' => $biller->previousMeterReading->current_units,
                'bill' => json_encode($biller->calculate()),
            ]); 
    
            // NotifyTenant::dispatch($meterReading);

            return new MeterReadingResource($meterReading);
        });

        return response()->json([
            'data' => $meterReading,
            'message' => 'Meter reading recorded. Tenant will be notified'
        ]);
    }
}
