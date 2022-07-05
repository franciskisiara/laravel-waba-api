<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Models\Apartment;
use App\Models\House;
use App\Models\MeterReading;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment)
    {
        $tenants = Tenant::whereHas('house.apartment', function ($query) use ($apartment) {
            $query->where('apartments.id', $apartment->id);
        })
            ->paginate()
            ->toArray();

        return response()->json([
            'data' => $tenants['data'],
            'meta' => Arr::except($tenants, ['data'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenantRequest $request, Apartment $apartment)
    {
        $tenant = DB::transaction(function () use($request) {
            $user = User::firstOrCreate([
                'phone' => $request->user['phone'],
            ], $request->user);

            $tenant = Tenant::create([
                'user_id' => $user->id,
                'house_id' => $request->house_id,
            ]);

            MeterReading::create([
                'tenant_id' => $tenant->id,
                'current_reading' => $request->current_reading,
            ]);

            return $tenant;
        });

        return response()->json([
            'data' => $tenant,
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
