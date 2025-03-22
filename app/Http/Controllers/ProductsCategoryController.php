<?php

namespace App\Http\Controllers;

use App\Models\ProductsCategory;
use Illuminate\Http\Request;

class ProductsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductsCategory::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

          'name'=>'required|string|unique:product_category,name',
        ]);
        ProductsCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductsCategory $products_category)
    {
     return $products_category;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductsCategory $products_category)
    {
        $request->validate([

            'name'=>'required|string|unique:product_category,name',
          ]);
          $products_category->update($request->all());
          return $products_category;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductsCategory $products_category)
    {
      $products_category->delete();
      return response()->json(['message'=>'categorie deleted']);
    }
}
