<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        $caretakerId = $request->user()->id;

        $apartment = Apartment::firstOrCreate([
            'caretaker_id' => $caretakerId,
        ], $request->only([
            'name', 'unit_rate', 'flat_rate', 'flat_rate_limit'
        ]));

        return response()->json([
            'data' => new ApartmentResource($apartment),
            'message' => 'Apartment details saved successfully'
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update (UpdateApartmentRequest $request, Apartment $apartment)
    {
        $apartment->update($request->only([
            'name', 'unit_rate', 'flat_rate', 'flat_rate_limit'
        ]));

        return response()->json([
            'data' => new ApartmentResource($apartment),
            'message' => 'Apartment details saved successfully'
        ], 200);
    }
}
