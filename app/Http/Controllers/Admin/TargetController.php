<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Target\StoreTargetRequest;
use App\Models\Product;
use App\Models\Target;
use App\Models\Targetproduct;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('designation', "!=", "Super Admin")
            ->get();
        $products = Product::all();
        $teams = Team::whereHas('users')
            ->get();
        $targets = Target::when(request('userId'), function ($query, $userId) {
            $query->where('user_id', $userId);
        })
            // ->when(request('productId'), function ($query, $productId) {
            //     $query->where('product_id', $productId);
            // })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', "$status");
            })
            ->when(request('team_id'), function ($query, $team_id) {
                $query->where('team_id', "$team_id");
            })
            ->when(request('from'), function ($query, $from) {
                $query->where(function ($q) use ($from) {
                    // $q->whereDate('from', ">=", $from)
                    // ->orWhereDate('to', ">=", $from)
                    $q->whereDate('created_at', "<=", $from);
                });
            })
            ->when(request('to'), function ($query, $to) {
                $query->where(function ($q) use ($to) {
                    // $q->whereDate('from', "<=", $to)
                    // ->whereDate('to', "<=", $to)
                    $q->whereDate('created_at', ">=", $to);
                });
            })
            ->when(request('search'), function ($query, $search) {
                $query->whereRelation('user', 'user_name', 'LIKE', "$search%")
                    ->orWhere('name', "LIKE", "$search%");
                // ->orWhereRelation('user', 'designation', 'LIKE', "$search%");
            })
            ->with(['targetproduct', 'user', 'team'])
            ->latest()
            ->paginate(15)
            ->withQueryString();
        return view('target.index', ['users' => $users, 'products' => $products, 'targets' => $targets, 'teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('designation', "!=", "Super Admin")
            ->get();
        $teams = Team::where('status', 'active')
            ->whereHas('users')
            ->get();
        $products = Product::all();
        return view('target.create', ['users' => $users, 'products' => $products, 'teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTargetRequest $request)
    {
        // dd($request->all());
        $validator = $request->validated();
        // dd($validator);
        $target = Target::create($validator);
        // if (
        //     isset($validator['product_id']) && isset($validator['target']) &&
        //     count($validator['product_id']) == count($validator['target'])
        // ) {
        //     // dd(count($validator['product_id']));
        //     for ($i = 0; $i < count($validator['product_id']); $i++) {
        //         $productId = $validator['product_id'][$i];
        //         $targetCount = (int) $validator['target'][$i];

        //         // Only proceed if targetCount is positive
        //         if ($targetCount > 0) {
        //             for ($j = 0; $j < $targetCount; $j++) {
        //                 Targetproduct::create([
        //                     'target_id' => $target->id,
        //                     'product_id' => $productId,
        //                 ]);
        //             }
        //         }
        //     }
        //     return to_route('admin.target.index')->with('success', "Target created successfully!!!");
        // } else {
        //     // dd("out");
        //     return back()->with('error', "Something went wrong in the product and target");
        // }
        foreach ($validator['incentive'] as $incentive) {
            Targetproduct::create([
                'target_id' => $target?->id,
                'incentive' => $incentive,
            ]);
        }
        return to_route('admin.target.index')->with('success', "Target created successfully!!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        //
    }

    public function productdetails(Request $request)
    {
        // dd($request->all());
        $product = Product::where('id', $request->productId)
            ->first();
        if (isset($product)) {
            $amount = $product->price;
            return new JsonResponse([
                'success' => true,
                "amount" => $amount
            ]);
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => "product not found"
            ]);
        }
    }

    public function checktarget()
    {
        // Update only targets that are active AND the 'to' date has passed
        Target::where('status', 1)
            ->whereDate('to', '<', Carbon::today())
            ->update(['status' => 3]);

        return new JsonResponse([
            'success' => true,
            'message' => 'targets updated successfully!'
        ]);
    }
}
