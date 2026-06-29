<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        // dd("product");
        $products = Product::latest()->get();
        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $productcategory = ProductCategory::latest()->where('status', 'active')->get();
        return view('product.create', ['productcategorys' => $productcategory, 'brands' => $brands]);
    }
    
    
    
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'product_type' => 'required',
          'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:product_categories,id',
        'subcategory_id' => 'required|exists:product_subcategories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'english' => 'required|file|mimes:pdf',
        'tamil' => 'required|file|mimes:pdf',
        ]);
        

        if ($request->hasFile('tamil')) {
            $pdfName = uniqid() . "." . $request->tamil->extension();
            $request->tamil->move(public_path('product/voucher/'), $pdfName);
            $validator['tamil'] = $pdfName;
        }

        if ($request->hasFile('english')) {
            $pdfName = uniqid() . "." . $request->english->extension();
            $request->english->move(public_path('product/voucher/'), $pdfName);
            $validator['english'] = $pdfName;
        }
        
        
        Product::create($validator);
        //dd($request->all());
        return redirect()->route('productList')->with('success', "Product Added Succesfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product);
        $brands = Brand::all();
        $productcategory = ProductCategory::latest()->where('status', 'active')->get();
        $productsubcategory = ProductSubcategory::latest()->where('status', 'active')->get();

        return view('product.edit', ['productcategorys' => $productcategory, 'productsubcategorys' => $productsubcategory, 'product' => $product, 'brands' => $brands]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'price' => 'required',
            'name' => 'required',
            'tamil' => 'nullable',
            'english' => 'nullable'
        ]);

        if ($request->hasFile('tamil')) {
            $pdfName = uniqid() . "." . $request->tamil->extension();
            $request->tamil->move(public_path('product/voucher/'), $pdfName);
            $validator['tamil'] = $pdfName;
        }

        if ($request->hasFile('english')) {
            $pdfName = uniqid() . "." . $request->english->extension();
            $request->english->move(public_path('product/voucher/'), $pdfName);
            $validator['english'] = $pdfName;
        }

        $product->update($validator);
        return redirect()->route('productList')->with('success', "Product Edited Succesfully");
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return redirect()->route('productList')
            ->with('error', 'Product not found');
    }

    if ($product->sale()->exists()) {
        return back()->with('error', 'Unable to delete product');
    }

    $product->delete();

    return redirect()->route('productList')
        ->with('success', 'Product deleted successfully');
}

     
    public function old_destroy($id)
    {
        // Find the ProductCategory by ID
        $product = Product::find($id);
        if ($product->sale()->exists()) {
            return back()->with('error', "unable to delete the product");
        }
        // Check if the category exists
        if (!$product) {

            return redirect()->route('product.index')->with('error', 'product not found.');
        }

        Log::info('Attempting to delete category ID: ' . $product->id);

        // Check if the category has subcategories
        if ($product->client()->count() > 0) {
            return redirect()->route('product.index')->with('error', 'This product has used in client so cannot be deleted.');
        }

        // Attempt to delete the category
        try {
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions during deletion
            return redirect()->route('product.index')->with('error', 'An error occurred while deleting the product.');
        }
    }

    public function changeStatus(Request $request)
    {
        if (env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $product = Product::find($request->id);
        $product->status = $product->status == 'active' ? 'inactive' : 'active';
        $product->save();

        return response()->json('Status Updated Successfully.');
    }
}
