<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Apartment;
use App\Models\Tenancy;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request, Apartment $apartment)
    {
        $tenancy = Tenancy::find($request->tenancy_id);
        $balance = $tenancy->running_balance - $request->amount;
        $tenancy->update(['running_balance' => $balance]);

        return response()->json([
            'message' => 'Payments details recorded successfully'
        ]);
    }
}
