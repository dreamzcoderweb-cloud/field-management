<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionTransaction;
use App\Models\Sale;
use App\Models\SaleCollection;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = SaleCollection::with(['client', 'product'])
            ->latest()
            ->get();

        return view('collections.index', ['collections' => $collections]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sales = Sale::with(['client', 'product'])
            ->whereDoesntHave('ledger', function ($query) {
                $query->where('status', 1);
            })
            ->where('is_completed', 0)
            ->whereDoesntHave('collection')
            ->latest()
            ->get();

        return view('collections.create', ['sales' => $sales]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'sale_id' => 'required|exists:sales,id|unique:collections,sale_id',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'nullable|numeric|lte:total_amount',  
            'balance_amount' => 'required|numeric|min:0',
            'emi_amount' => 'required|numeric|min:0',
            'emi_date' => 'nullable|integer|min:1|max:31',
            'total_months' => 'nullable|integer|min:1',
            'paid_months' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $sale = Sale::with(['client', 'product'])->findOrFail($validator['sale_id']);

        $validator['client_id'] = $sale->client_id;
        $validator['product_id'] = $sale->product_id;
        $validator = $this->normalizeCollectionInput($validator);
        $validator['created_by_id'] = $this->currentUserId();

        $collection = SaleCollection::create($validator);
        $this->createOpeningTransactionIfNeeded($collection);
        $this->syncSaleFromCollection($collection);

        return redirect()->route('collections.index')->with('success', 'Collection Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleCollection $collection)
    {
        return view('collections.show', [
            'collection' => $collection->load(['client', 'product', 'sale', 'transactions']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleCollection $collection)
    {
        return view('collections.edit', [
            'collection' => $collection->load(['client', 'product', 'sale']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleCollection $collection)
    {
        $validator = $request->validate([
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric|lte:total_amount',
            'balance_amount' => 'required|numeric|min:0',
            'emi_amount' => 'required|numeric|min:0',
            'emi_date' => 'required|integer|min:1|max:31',
            'total_months' => 'required|integer|min:1',
            'paid_months' => 'required|integer|min:0',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $validator = $this->normalizeCollectionInput($validator);
        $validator['updated_by_id'] = $this->currentUserId();

        $collection->update($validator);
        $this->createOpeningTransactionIfNeeded($collection->fresh());
        $this->syncSaleFromCollection($collection->fresh('sale'));

        return redirect()->route('collections.index')->with('success', 'Collection Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleCollection $collection)
    {
        $collection->delete();

        return redirect()->route('collections.index')->with('success', 'Collection Deleted Successfully');
    }

    public function storeTransaction(Request $request, SaleCollection $collection)
    {
        $validator = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $collection->balance_amount,
            'payment_date' => 'required|date',
            'emi_month' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $validator['collection_id'] = $collection->id;
        $validator['client_id'] = $collection->client_id;
        $validator['sale_id'] = $collection->sale_id;
        $validator['product_id'] = $collection->product_id;
        $validator['created_by_id'] = $this->currentUserId();

        CollectionTransaction::create($validator);

        $this->refreshCollectionAmounts($collection);

        return back()->with('success', 'Collection Transaction Added Successfully');
    }

    public function destroyTransaction(CollectionTransaction $transaction)
    {
        $collection = $transaction->collection;
        $transaction->delete();

        if ($collection) {
            $this->refreshCollectionAmounts($collection);
        }

        return back()->with('success', 'Collection Transaction Deleted Successfully');
    }

    private function refreshCollectionAmounts(SaleCollection $collection): void
    {
        $collection->loadMissing('sale');

        $paidAmount = (float) $collection->transactions()->sum('amount');
        $balanceAmount = max(((float) $collection->total_amount) - $paidAmount, 0);
        $paidMonths = $this->calculatePaidMonths($collection, $paidAmount, $balanceAmount);

        $collection->update([
            'paid_amount' => $paidAmount,
            'balance_amount' => $balanceAmount,
            'paid_months' => $paidMonths,
            'status' => $balanceAmount <= 0 ? 'completed' : 'pending',
            'updated_by_id' => $this->currentUserId(),
        ]);

        $this->syncSaleFromCollection($collection->fresh('sale'));
    }

    private function calculatePaidMonths(SaleCollection $collection, float $paidAmount, float $balanceAmount): int
    {
        return $this->calculatePaidMonthsFromValues(
            (int) $collection->total_months,
            (float) $collection->emi_amount,
            $paidAmount,
            $balanceAmount
        );
    }

    private function normalizeCollectionInput(array $data): array
    {
        $totalAmount = (float) ($data['total_amount'] ?? 0);
        $paidAmount = min((float) ($data['paid_amount'] ?? 0), $totalAmount);
        $balanceAmount = max($totalAmount - $paidAmount, 0);

        $data['paid_amount'] = $paidAmount;
        $data['balance_amount'] = $balanceAmount;
        $data['paid_months'] = $this->calculatePaidMonthsFromValues(
            (int) ($data['total_months'] ?? 0),
            (float) ($data['emi_amount'] ?? 0),
            $paidAmount,
            $balanceAmount
        );

        if (($data['status'] ?? 'pending') !== 'cancelled') {
            $data['status'] = $balanceAmount <= 0 ? 'completed' : 'pending';
        }

        return $data;
    }

    private function calculatePaidMonthsFromValues(int $totalMonths, float $emiAmount, float $paidAmount, float $balanceAmount): int
    {
        if ($balanceAmount <= 0) {
            return $totalMonths;
        }

        if ($emiAmount <= 0) {
            return 0;
        }

        return min($totalMonths, (int) floor($paidAmount / $emiAmount));
    }

    private function syncSaleFromCollection(SaleCollection $collection): void
    {
        $collection->loadMissing('sale');

        $balanceAmount = (float) $collection->balance_amount;
        $salePaidAmount = max(((float) $collection->sale?->amount) - $balanceAmount, 0);

        $collection->sale?->update([
            'paid_amount' => $salePaidAmount,
            'balance' => $balanceAmount,
            'is_completed' => $balanceAmount <= 0 ? 1 : 0,
        ]);
    }

    private function createOpeningTransactionIfNeeded(SaleCollection $collection): void
    {
        if ((float) $collection->paid_amount <= 0 || $collection->transactions()->exists()) {
            return;
        }

        CollectionTransaction::create([
            'collection_id' => $collection->id,
            'client_id' => $collection->client_id,
            'sale_id' => $collection->sale_id,
            'product_id' => $collection->product_id,
            'amount' => $collection->paid_amount,
            'payment_date' => now()->format('Y-m-d'),
            'emi_month' => 1,
            'notes' => 'Opening payment',
            'created_by_id' => $this->currentUserId(),
        ]);
    }

    private function currentUserId(): ?int
    {
        return Sentinel::getUser()?->id ?? auth()->id();
    }
}
