<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApartmentRequest;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

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
        ], array_merge($request->all(), [
            'caretaker_id' => $caretakerId
        ]));

        return response()->json([
            'data' => $apartment,
            'message' => 'Apartment saved successfully'
        ]);
    }
}
