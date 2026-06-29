<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategory = ProductCategory::with('brand')
            ->latest()
            ->get();
        return view('productcategory.index', ['productCategorys' => $productCategory]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        return view('productcategory.create', ['brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'brand_id' => 'required'
        ]);
        $productCategory = ProductCategory::create($validator);
        return redirect()->route('productcategory.index')->with('success', 'Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        $brands = Brand::all();
        return view('productcategory.edit', ['brands' => $brands, 'productCategory' => $productCategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validator = $request->validate([
            'name' => 'required',
            'brand_id' => 'required'
        ]);
        $productCategory->update($validator);
        return to_route('productcategory.index')->with('success', "Category Updated!!!");
    }

    /**
     * Remove the specified resource from storage.
     */



    public function destroy($id)
    {
        // Find the ProductCategory by ID
        $productCategory = ProductCategory::find($id);

        // Check if the category exists
        if (!$productCategory) {
            Log::error('ProductCategory not found for ID: ' . $id);
            return redirect()->route('productcategory.index')->with('error', 'Category not found.');
        }

        Log::info('Attempting to delete category ID: ' . $productCategory->id);

        // Check if the category has subcategories
        if ($productCategory->productsubcategory()->count() > 0) {
            Log::warning('Category ID ' . $productCategory->id . ' has subcategories and cannot be deleted.');
            return redirect()->route('productcategory.index')->with('error', 'This category has subcategories and cannot be deleted.');
        }

        // Attempt to delete the category
        try {
            $productCategory->delete();
            Log::info('Category successfully deleted: ' . $productCategory->id);
            return redirect()->route('productcategory.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions during deletion
            Log::error('Error deleting category ID: ' . $productCategory->id . '. Error: ' . $e->getMessage());
            return redirect()->route('productcategory.index')->with('error', 'An error occurred while deleting the category.');
        }
    }





    public function changeStatus(Request $request)
    {
        if (env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $productcategory = ProductCategory::find($request->id);
        $productcategory->status = $productcategory->status == 'active' ? 'inactive' : 'active';
        $productcategory->save();

        return response()->json('Status Updated Successfully.');
    }
}
