<?php

namespace App\Http\Controllers;

use App\Models\Supermarket;
use Illuminate\Http\Request;

class SupermarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Supermarket::all();
    }

    /**

     */
    public function store(Request $request)
    {
        $request->validate([
          'name'=>'required|string',
          'ip_address'=>'required|ip|unique:supermarkets',
        ]);
        return Supermarket::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Supermarket $supermarket)
    {
        return $supermarket;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supermarket $supermarket)
    {
        $request->validate([
            'name'=>'required|string',
            'ip_address'=>'required|ip|unique:supermarkets',
          ]);
        $supermarket->update($request->all());
        return $supermarket;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supermarket $supermarket)
    {
       $supermarket->delete();
       return response()->json(['message'=>'supermarket deleted']);
    }
}
