<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['brand', 'category', 'subcategory', 'stock'])
            ->where('status', 'active')
            ->latest()
            ->get();
        return new JsonResponse([
            'success' => true,
            'products' => $products
        ]);
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
    public function show(Request $request, Product $product)
    {
        $language = $request->language;

        if ($language == null) {
            return Error::response('Language is required');
        }
        $fileName = $product->$language;

        if (!$fileName || !file_exists(public_path('product/voucher/' . $fileName))) {
            return \App\Api\Shared\Responses\Error::response('File not found', 404);
        }

        $filePath = public_path('product/voucher/' . $fileName);

        // Download the PDF
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
