<?php

namespace App\Http\Controllers;

use App\Http\Filters\TenancyFilter;
use App\Http\Requests\StoreTenancyRequest;
use App\Http\Resources\TenancyResource;
use App\Http\Resources\TenancyResourceCollection;
use App\Models\Apartment;
use App\Models\House;
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
        $tenancies = osmose(TenancyFilter::class)
            ->with(['tenant', 'house'])
            ->orderBy('id', 'desc')
            ->paginate(15);
        
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

            $tenancy = $house->tenancies()->create([
                'tenant_id' => $user->id
            ]);

            $house->update([
                'tenant_id' => $user->id
            ]);

            $tenancy->readings()->create([
                'current_units' => $request->meter_reading,
            ]);

            return new TenancyResource($tenancy);
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
        $tenancyApartment = $tenancy->house->apartment;

        if ($tenancyApartment->id !== $apartment->id) {
            return response()->json([
                'message' => 'Tenancy does not exist'
            ], 404);
        }

        DB::transaction(function () use($tenancy) {
            $tenancy->house->update(['tenant_id' => null]);
            $tenancy->delete();
        });

        return response()->json([
            'message' => 'Tenant removed successfully',
        ]);
    }
}
