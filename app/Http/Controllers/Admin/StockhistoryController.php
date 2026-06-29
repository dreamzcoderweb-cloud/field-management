<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stockhistory\StoreStockhistoryRequest;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Stockhistory;
use Illuminate\Http\Request;

class StockhistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stockhistories = Stockhistory::when(request('search'), function ($query, $search) {
            $query->where('amount', 'LIKE', "$search%")
                ->orWhereRelation('product', 'name', 'LIKE', "$search%");
        })
            ->when(request('from'), function ($query, $from) {
                $query->where('created_at', '>=', $from);
            })
            ->when(request('to'), function ($query, $to) {
                $query->where('created_at', '<=', $to);
            })
            ->when(request('type'), function ($query, $type) {
                $query->where('type', $type);
            })
            ->where('stock_id', $request->stock_id)
            ->with('stock', 'product')
            ->latest()
            ->paginate(15);
        return view('stockhistory.index', ['stockhistories' => $stockhistories, 'stock_id' => $request?->stock_id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('stockhistory.create', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockhistoryRequest $request)
    {
        $validator = $request->validated();
        // dd($validator);
        $stock = Stock::where('product_id', $validator['product_id'])
            ->first();
        if (isset($stock)) {
            // dd("if");
            $stock->quantity += $validator['quantity'];
            $stock->update();
            $stock = Stock::where('product_id', $validator['product_id'])
                ->first();
            $validator['stock_id'] = $stock->id;
            Stockhistory::create($validator);
        } else {
            // dd("else");
            $stock = Stock::create($validator);
            $validator['stock_id'] = $stock->id;
            Stockhistory::create($validator);
        }
        return to_route('admin.stock.index')->with('success', "Stock Added!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Stockhistory $stockhistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stockhistory $stockhistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stockhistory $stockhistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stockhistory $stockhistory)
    {
        $stock = Stock::where('id', $stockhistory->stock_id)
            ->first();
        $stock->quantity -= $stockhistory->quantity;
        $stock->update();
        $stockhistory->delete();
        return back()->with('success', "Stock removed!");
    }
}
