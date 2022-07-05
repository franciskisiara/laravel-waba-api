<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHouseRequest;
use App\Models\Apartment;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment)
    {
        $houses = House::where('apartment_id', $apartment->id)
            ->orderBy('house_number', 'asc')
            ->paginate()
            ->toArray();

        return response()->json([
            'data' => $houses['data'],
            'meta' => Arr::except($houses, ['data'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHouseRequest $request, Apartment $apartment)
    {
        $house = House::create([
            'apartment_id' => $apartment->id,
            'house_number' => $request->house_number, 
        ]);

        return response()->json([
            'data' => $house,
            'message' => 'House details saved successfully',
        ]);
    }
}
