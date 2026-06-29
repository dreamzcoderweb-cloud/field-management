<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\SaleCollection;

class OutstandingClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $clients = Client::whereHas('sale', function ($query) {
            $query->where('is_completed', 0);
        })
            ->where('created_by_id', Auth::id())
            ->latest()
            ->with(['sale' => function ($query) {
                $query->where('is_completed', 0)->with('product', 'product.brand', 'product.category', 'product.subcategory');
            }])
            ->get();
        return new JsonResponse([
            'success' => true,
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(Request $request)
    // {
    //     $validator = $request->validate([
    //         'client_id' => 'nullable'
    //     ]);
    //     $clientId = $request->client_id;
    //     $clients = Client::whereHas('sale', function ($query) {
    //         $query->where('is_completed', 0);
    //     })
    //         // ->where('id', $request?->client_id)
    //         ->when(request('client_id'), function ($query) use ($clientId) {
    //             $query->where('id', $clientId);
    //         })
    //         ->where('created_by_id', Auth::id())
    //         ->latest()
    //         ->with(['sale' => function ($query) {
    //             $query->where('is_completed', 0)->with('product', 'product.brand', 'product.category', 'product.subcategory');
    //         }])
    //         ->get();
    //     if (!$clients) {
    //         return \App\Api\Shared\Responses\Error::response('No outstanding sale found', 404);
    //     }
    //     if ($request?->client_id != null) {
    //         // Render Blade into PDF
    //         $pdf = Pdf::loadView('clientwise', ['clients' => $clients]);
    //         $title = "clientLedger-";
    //     } else {
    //         // Render Blade into PDF
    //         $pdf = Pdf::loadView('outstanding', ['clients' => $clients]);
    //         $title = "outstandingClients-";
    //     }

    //     // Download the PDF
    //     return $pdf->download($title . now()->format('d-m-Y') . '.pdf');
    // }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'nullable'
        ]);

        $clientId = $request->client_id;

        $clients = Client::whereHas('sale', function ($query) {
                $query->where('is_completed', 0);
            })
            ->when($clientId, function ($query) use ($clientId) {
                $query->where('id', $clientId);
            })
            ->where('created_by_id', Auth::id())
            ->latest()
            ->with([

                // sales details
                'sale' => function ($query) {

                    $query->where('is_completed', 0)
                        ->with([

                            // product details
                            'product',
                            'advance',
                            'product.brand',
                            'product.category',
                            'product.subcategory',

                            // collections
                            'collections',

                            // collection transactions
                            'collections.collectionTransactions'
                        ]);
                }

            ])
            ->get();
        if ($clients->isEmpty()) {

            return \App\Api\Shared\Responses\Error::response(
                'No outstanding sale found',
                404
            );
        }

        if ($clientId != null) {

            $pdf = Pdf::loadView('clientwise', [
                'clients' => $clients
            ]);

            $title = "clientLedger-";
           
        } else {

            $pdf = Pdf::loadView('outstanding', [
                'clients' => $clients
            ]);

            $title = "outstandingClients-";
        }

        return $pdf->download(
            $title . now()->format('d-m-Y') . '.pdf'
        );
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
        $salesummary = Sale::with(['product', 'client', 'bank', 'due', 'advance', 'duty'])
            ->where('client_id', $client->id)
            ->where('status', 0)
            ->latest()
            ->first();

        if (!$salesummary) {
            return \App\Api\Shared\Responses\Error::response('No outstanding sale found', 404);
        }

        // Pass correct variable to the view
        $html = view('salesummary', ['sale' => $salesummary])->render();

        return response($html)
            ->header('Content-Type', 'application/pdf') // pretend PDF
            ->header('Content-Disposition', 'attachment; filename="' . $client->name . '.pdf"');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
