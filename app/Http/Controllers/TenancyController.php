<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenancyRequest;
use App\Models\Apartment;
use App\Models\House;
use App\Models\MeterReading;
use App\Models\Tenancy;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TenancyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenancyRequest $request, Apartment $apartment)
    {
        $tenancy = DB::transaction(function () use($request) {
            $user = User::firstOrCreate([
                'phone' => $request->tenant['phone'],
            ], $request->tenant);

            $house = House::find($request->house_id);

            $tenancy = $house->tenancies()->create([
                'user_id' => $user->id,
            ]);

            $house->update([
                'tenant_id' => $user->id
            ]);

            MeterReading::create([
                'tenancy_id' => $tenancy->id,
                'aft_reading' => $request->reading,
            ]);

            return $tenancy;
        });

        return response()->json([
            'data' => $tenancy,
            'message' => 'Tenant details saved successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment, Tenant $tenant)
    {
        $tenant->delete();

        return response()->json([
            'message' => 'Tenant removed successfully',
        ]);
    }
}
