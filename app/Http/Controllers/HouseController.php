<?php

namespace App\Http\Controllers;

use App\Http\Filters\ApartmentFilter;
use App\Http\Filters\HouseFilter;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Resources\HouseResource;
use App\Http\Resources\HouseResourceCollection;
use App\Models\Apartment;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment)
    {
        $houses = osmose(HouseFilter::class)
            ->with(['tenant'])
            ->orderBy('house_number', 'asc')
            ->paginate(25);

        return new HouseResourceCollection($houses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHouseRequest $request, Apartment $apartment)
    {
        $house = DB::transaction(function () use ($request, $apartment) {
            $house = House::updateOrCreate([
                'apartment_id' => $apartment->id,
                'house_number' => str_replace(' ', '', strtoupper($request->house_number)),
            ]);

            return new HouseResource($house);
        });

        return response()->json([
            'data' => $house,
            'message' => 'House details saved successfully',
        ]);
    }
}
