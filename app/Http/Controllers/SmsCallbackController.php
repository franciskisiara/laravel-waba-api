<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsCallbackController
{
    public function delivery (Request $request)
    {
        $deliveryStatus = strtolower($request->status);
        $meterReading = MeterReading::where('bill_delivery_id', $request->id)->first();

        if (!is_null($meterReading)) {
            Log::info(json_encode($meterReading));

            $meterReading->update([
                'bill_delivery_status' => $deliveryStatus
            ]);
        }
    }
}