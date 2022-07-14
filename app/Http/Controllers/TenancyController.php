<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenancyRequest;
use App\Http\Resources\TenancyResourceCollection;
use App\Models\Apartment;
use App\Models\House;
use App\Models\MeterReading;
use App\Models\Tenancy;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TenancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment)
    {
        $tenancies = Tenancy::whereHas('house', function ($builder) use ($apartment) {
            $builder->where('houses.apartment_id', $apartment->id);
        })
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return new TenancyResourceCollection($tenancies);
    }

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

            $tenancy = $house->tenancies()->create(['user_id' => $user->id]);

            $house->update(['tenant_id' => $user->id]);

            MeterReading::create([
                'tenancy_id' => $tenancy->id,
                'current_units' => $request->meter_reading,
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
     * @param  \App\Models\Tenancy  $tenancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment, Tenancy $tenancy)
    {
        DB::transaction(function () use($tenancy) {
            $tenancy->house->update(['tenant_id' => null]);
            $tenancy->delete();
        });

        return response()->json([
            'message' => 'Tenant removed successfully',
        ]);
    }
}
