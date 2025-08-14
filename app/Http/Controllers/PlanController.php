<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Yajra\DataTables\Facades\DataTables;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.subscriptions.plans.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.subscriptions.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'limit' => 'nullable|integer|min:0',
            'duration' => 'required|string|max:255',
            'razorpay_plan_id' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);

        Plan::create($validated);

        return response()->json(['message' => 'Plan created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.subscriptions.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Plan::findOrFail($id)->delete();
        return response()->json(['message' => 'Plan deleted successfully']);
    }
    public function getData()
{
    $plans = Plan::select(['id', 'name', 'razorpay_plan_id', 'price', 'limit', 'currency', 'duration'])
        ->get()
        ->map(function ($plan) {
            return [
                'id' => $plan->id,
                'plan_name' => $plan->name,
                'razorpay_plan_id' => $plan->razorpay_plan_id ?? '-',
                'price' => $plan->currency . ' ' . number_format($plan->price, 2),
                'currency' => $plan->currency,
                'limit' => $plan->limit ?? 'Unlimited',
                'duration' => $plan->duration,
                // 'status_label' => $plan->deleted_at ? 'Deleted' : 'Active',
                // 'deleted_at' => $plan->deleted_at,
                'actions' => $plan->id,
            ];
        });

    return DataTables::of($plans)->make(true);
}
}
