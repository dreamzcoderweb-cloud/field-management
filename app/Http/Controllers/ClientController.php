<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $categories = ProductCategory::latest()->where('status','active')->get();
        $subcategories = ProductSubcategory::latest()->where('status','active')->get();
        $products = Product::latest()->where('status','active')->get();
        $bank = Bank::latest()->where('status','active')->get();
        return view('client.edit', ['client' => $client,'categories'=>$categories,'subcategories'=>$subcategories,'products'=>$products,'banks'=>$bank]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = $request->validate([
               'total_amount'=> 'required',
               'paid_amount'=> 'required',
               'balance_amount'=> 'required',
               'category_id' => 'required',
               'subcategory_id' => 'required',
               'product_id' => 'required',
               'bank_id' => 'required',
              
        ]);

        $client->update($validator);
        return redirect()->route('client.index')->with('success','Client details edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }

    public function getSubcategories(Request $request)
{
    $subcategories = ProductSubcategory::where('product_category_id', $request->category_id)
                                        ->where('status','active')
                                        ->get();
    return response()->json($subcategories);
}

public function getProducts(Request $request)
{
    $products = Product::where('category_id', $request->category_id)
                       ->where('subcategory_id', $request->subcategory_id)
                       ->where('status','active')
                       ->get();
    return response()->json($products);
}

public function getProductPrice(Request $request)
{
    $product = Product::find($request->product_id);

    if ($product) {
        return response()->json(['price' => $product->price]);
    }

    return response()->json(['price' => 0]); // Return 0 if product not found
}


}
