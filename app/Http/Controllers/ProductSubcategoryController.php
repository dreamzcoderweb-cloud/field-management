<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;

class ProductSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productSubcategory = ProductSubcategory::latest()->get();
        return view('productsubcategory.index', ['productsubcategories' => $productSubcategory]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProductCategory::latest()->where('status', 'active')->get();
        return view('productsubcategory.create', ['categories' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'product_category_id' => 'required'
        ]);


        ProductSubcategory::create($validator);
        return redirect()->route('productsubcategory.index')->with('success', 'Varient Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSubcategory $productSubcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSubcategory $productSubcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSubcategory $productSubcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(ProductSubcategory $productSubcategory)
    // {
    //     $productSubcategory->delete();
    //     return redirect()->route('productsubcategory.index')->with('success','Varient Deleted Successfully');

    // }

    public function changeStatus(Request $request)
    {
        if (env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $productsubcategory = ProductSubcategory::find($request->id);
        $productsubcategory->status = $productsubcategory->status == 'active' ? 'inactive' : 'active';
        $productsubcategory->save();

        return response()->json('Status Updated Successfully.');
    }


    public function getSubcategories($categoryId)
    {
        $subcategories = ProductSubcategory::where('product_category_id', $categoryId)
            ->where('status', 'active')
            ->get();

        // Return as JSON
        return response()->json($subcategories);
    }
}
