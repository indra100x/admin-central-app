<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          return Supplier::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'phone_number'=>'required|string',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
        ]);
        return Supplier::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {

       return $supplier;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'=>'required|string',
            'phone_number'=>'required|string',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
        ]);
         $supplier->update($request->all());
         return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
       $supplier->delete();
       return response()->json(['message'=>'supplier deleted']);
    }
}
