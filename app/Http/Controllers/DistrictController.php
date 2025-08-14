<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\District;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    public function index()
    {
        return view('admin.districts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::where('status', 1)->get(); // Only active states
        return view('admin.districts.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'districts_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        District::create([
            'state_id' => $request->state_id,
            'name' => $request->districts_name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
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
    public function edit($id)
    {
        $districts = District::withTrashed()->findOrFail($id);
        $states = State::where('status', 1)->get();
        return view('admin.districts.edit', compact('districts', 'states'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'districts_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $District = District::findOrFail($id);
        $District->update([
            'state_id' => $request->state_id,
            'name' => $request->districts_name,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'District updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(District $District)
    {
        $District->delete();
        return response()->json(['success' => true, 'message' => 'District soft deleted.']);
    }
    
    public function restore($id)
    {
        $District = District::onlyTrashed()->findOrFail($id);
        $District->restore();

        return response()->json(['success' => true, 'message' => 'District restored.']);
    }

    public function data()
    {
        $cities = District::with(['state'])
            ->withTrashed()
            ->select(['id', 'name', 'state_id', 'status', 'deleted_at'])
            ->get()
            ->map(function ($District) {
                return [
                    'id' => $District->id,
                    'districts_name' => $District->name,
                    'state_name' =>  $District->state->name ?? '—',
                    'status' => $District->status,
                    'status_label' => $District->deleted_at ? 'Deleted' : 'Active',
                    'deleted_at' => $District->deleted_at,
                    'actions' => $District->id
                ];
            });

        return DataTables::of($cities)->make(true);
    }
    public function getDistricts($stateId)
    {
        $districts = District::where('state_id', $stateId)->get();

        return response()->json($districts);
    }
}
