<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Location::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'supermarket_id'=>'required|exists:supermarket,id',
        'street_name'=>'required|string',
        'state'=>'required|string',
        'latitude'=>'required|numeric',
        'longitude'=>'required|numeric'
        ]);
        return Location::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return $location;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'supermarket_id'=>'required|exists:supermarket,id',
            'street_name'=>'required|string',
            'state'=>'required|string',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric'
            ]);
            $location->update($request->all());
            return $location;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
      $location->delete();
      return response()->json(['message'=>'location deleted']);
    }
}
