<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.states.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.states.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'state_name' => 'required|string|max:255|unique:states,name',
            'status'     => 'required|boolean',
        ]);

        $state = new State();
        $state->name = $request->state_name;
        $state->status = $request->status;
        $state->save();

        return response()->json([
            'message' => 'State created successfully',
            'state' => $state
        ], 201);
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
        $state = State::withTrashed()->findOrFail($id);
        return view('admin.states.edit', compact('state'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $state = State::findOrFail($id);
        $state->update([
            'name' => $request->state_name,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'State updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $State)
    {
        $State->delete();
        return response()->json(['success' => true, 'message' => 'State soft deleted.']);
    }
    
    public function restore($id)
    {
        $State = State::onlyTrashed()->findOrFail($id);
        $State->restore();

        return response()->json(['success' => true, 'message' => 'State restored.']);
    }

    public function data(){
         $states = State::withTrashed()
        ->select(['id', 'name', 'status', 'deleted_at'])
        ->get()
        ->map(function ($state) {
            return [
                'id' => $state->id,
                'state_name' => $state->name,
                'status' => $state->status,
                'status_label' => $state->deleted_at ? 'Deleted' : 'Active',
                'deleted_at' => $state->deleted_at,
                'actions' => $state->id
            ];
        });

    return DataTables::of($states)->make(true);
    }
}
