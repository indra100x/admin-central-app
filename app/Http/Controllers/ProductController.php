<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'name'=>'required|string',
        'barcode'=>'required|string',
        'price'=>'required|decimal:0,2',
        'category_id'=>'exists:product_category,id',
        'supplier_id'=>'exists:supplier,id',
      ]);
      return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
      return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required|string',
            'barcode'=>'required|string',
            'price'=>'required|decimal:0,2',
            'category_id'=>'exists:product_category,id',
            'supplier_id'=>'exists:supplier,id',
          ]);
          $product->update($request->all());
          return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
      $product->delete();
      return response()->json(['message'=>'product deleted']);
    }
}
