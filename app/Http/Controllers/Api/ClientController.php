<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // public function getAllClients(Request $request)
    // {
    //     $skip = $request->skip;
    //     $take = $request->take ?? 10;
    //     $total = Client::where('status', 1)->count();
    //     $clients = Client::where('status', 1)->skip($skip)->take($take)->latest()->get();
    //     $finalClients = $this->getClients($clients)
    //     ->filter(function ($item) {
    //     if (!request('search')) return true;

    //     $search = strtolower(request('search'));

    //     return str_contains(strtolower($item['name']), $search)
    //         || str_contains(strtolower($item['email']), $search)
    //         || str_contains(strtolower($item['phoneNumber']), $search);
    // })
    // ->values();
    //      // $total_check = count($finalClients); 
    //     $response = [
    //         'totalCount' => count($finalClients),
    //         'clients' => $finalClients,
            
    //     ];
    //     return response()->json(['statusCode' => 200, 'status' => 'success', 'data' => $response,]);
    // }

    public function getAllClients(Request $request)
    {
        $skip = $request->skip ?? 0;
        $take = $request->take ?? 10;

        $clientsQuery = Client::with([
            'Sale.product.category',
            'Sale.product.subcategory'
        ])
        ->where('status', 1);

        // search filter
        if ($request->search) {
            $search = $request->search;

            $clientsQuery->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $total = $clientsQuery->count();

        $clients = $clientsQuery
            ->latest()
            ->skip($skip)
            ->take($take)
            ->get();

        $finalClients = $this->getClients($clients);

        $response = [
            'totalCount' => $total,
            'clients' => $finalClients,
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response,
        ]);
    }
    public function getAllClientsbackup(Request $request)
    {
        $skip = $request->skip;
        $take = $request->take ?? 10;

        $total = Client::where('status', 1)->count();

        $clients = Client::where('status', 1)->skip($skip)->take($take)->latest()->get();

        $finalClients = $this->getClients($clients);

        $response = [
            'totalCount' => $total,
            'clients' => $finalClients
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response,
        ]);
    }

    public function search(Request $request)
    {

        $query = $request->input('query');

        if ($query == null) {
            return Error::response('Query is required');
        }

        $clients = Client::where('status', 1)->where('name', 'like', '%' . $query . '%')
            ->take(10)
            ->get();

        $finalClients = $this->getClients($clients);

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $finalClients,
        ]);
    }

    public function create(Request $request)
    {

        $name = $request->name;
        $address = $request->address;
        $latitude = $request?->latitude;
        $longitude = $request?->longitude;
        $phoneNumber = $request->phoneNumber;
        $contactPerson = $request->contactPerson;

        $email = $request->email;
        $city = $request->city;
        $remarks = $request->remarks;

        if ($name == null) {
            return Error::response('Name is required');
        }

        if ($address == null) {
            return Error::response('Address is required');
        }

        // if ($latitude == null) {
        //     return Error::response('Latitude is required');
        //}

        //    if ($longitude == null) {
        //        return Error::response('Longitude is required');
        //    }

        if ($phoneNumber == null) {
            return Error::response('Phone Number is required');
        }

        if ($contactPerson == null) {
            return Error::response('Contact Person is required');
        }



        if ($city == null) {
            return Error::response('City is required');
        }

        Client::create([
            'name' => $name,
            'address' => $address,
            'latitude' => $request?->latitude,
            'longitude' => $request?->longitude,
            'phone' => $phoneNumber,
            'contact_person_name' => $contactPerson,

            'email' => $email,
            'city' => $city,
            'remarks' => $remarks,
            'created_by_id' => auth()->user()->id,
        ]);

        return Success::response('Client created successfully');
    }

    /**
     * @param $clients
     * @return mixed
     */
    // public function getClients($clients)
    // {
    //     $finalClients = $clients->map(function ($client) {
    //         return [
    //             'id' => $client->id,
    //             'name' => $client->name,
    //             'address' => $client->address,
    //             'city' => $client->city,
    //             'contactPerson' => $client->contact_person_name,
    //             // 'totalAmount' => $client->total_amount,
    //             // 'paidAmount ' => $client->paid_amount,
    //             // 'balanceAmount ' => $client->balance_amount,
    //             "category" => $client?->Sale()?->latest()->first()?->product?->category?->name,
    //             "sub_category" => $client?->Sale()?->latest()->first()?->product?->subcategory?->name,
    //             "product" => $client?->Sale()?->latest()->first()?->product?->name,
    //             "totalAmount" => $client?->Sale()?->latest()->first()?->amount,
    //             "paidAmount" => $client?->Sale()?->latest()->first()?->paid_amount,
    //             "balanceAmount" => $client?->Sale()?->latest()->first()?->balance,
    //             'email' => $client->email,
    //             'phoneNumber' => $client->phone,
    //             'latitude' => doubleval($client->latitude),
    //             'longitude' => doubleval($client->longitude),
    //             'status' => $client->status,
    //             'createdAt' => $client->created_at->format('Y-m-d H:i:s'),
    //             'updatedAt' => $client->updated_at->format('Y-m-d H:i:s'),
    //             'is_exchangable' => $client->Sale()?->latest()?->first()?->is_exchangable ?? 0,
    //             'exchangable_item' => $client->Sale()?->latest()?->first()?->exchangable_item,
    //             'exchangable_amount' => $client->Sale()?->latest()?->first()?->exchangable_amount,
    //             'vehicle_number' => $client->Sale()?->latest()?->first()?->vehicle_number,
    //             'vehicle_year' => $client->Sale()?->latest()?->first()?->vehicle_year,
    //         ];
    //     });
    //     return $finalClients;
    // }



public function getClients($clients)
{
    $finalClients = $clients->map(function ($client) {

        $sales = $client->Sale->map(function ($sale) {

            return [
                'sale_id' => $sale->id,

                'category' => $sale?->product?->category?->name,
                'sub_category' => $sale?->product?->subcategory?->name,
                'product' => $sale?->product?->name,
                'product_type' => $sale?->product?->product_type,
                'totalAmount' => $sale?->amount,
                'paidAmount' => $sale?->paid_amount,
                'balanceAmount' => $sale?->balance,

                'is_exchangable' => $sale?->is_exchangable ?? 0,
                'exchangable_item' => $sale?->exchangable_item,
                'exchangable_amount' => $sale?->exchangable_amount,

                'vehicle_number' => $sale?->vehicle_number,
                'vehicle_year' => $sale?->vehicle_year,

                'createdAt' => optional($sale->created_at)->format('Y-m-d H:i:s'),
                'updatedAt' => optional($sale->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        return [
            'id' => $client->id,
            'name' => $client->name,
            'address' => $client->address,
            'city' => $client->city,
            'contactPerson' => $client->contact_person_name,

            'email' => $client->email,
            'phoneNumber' => $client->phone,

            'latitude' => doubleval($client->latitude),
            'longitude' => doubleval($client->longitude),

            'status' => $client->status,

            'createdAt' => $client->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $client->updated_at->format('Y-m-d H:i:s'),

            // multiple sales records
            'sales' => $sales,
        ];
    });

    return $finalClients;
}
}

