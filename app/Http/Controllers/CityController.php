<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\City;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $District = District::where('status', 1)->get(); // Only active District
        return view('admin.cities.create', compact('District'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'city_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        City::create([
            'district_id' => $request->district_id,
            'name' => $request->city_name,
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
        $city = City::findOrFail($id);
        $districts = District::where('status', 1)->get();
        return view('admin.cities.edit', compact('city', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'city_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $city = City::findOrFail($id);
        $city->update([
            'district_id' => $request->district_id,
            'name' => $request->city_name,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'City updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(City $City)
    {
        $City->delete();
        return response()->json(['success' => true, 'message' => 'City soft deleted.']);
    }
    
    public function restore($id)
    {
        $City = City::findOrFail($id);
        $City->restore();

        return response()->json(['success' => true, 'message' => 'City restored.']);
    }

    public function data()
    {
        $cities = City::with(['district'])
            ->select(['id', 'name', 'district_id', 'status', 'deleted_at'])
            ->get()
            ->map(function ($city) {
                return [
                    'id' => $city->id,
                    'city_name' => $city->name,
                    'district_name' =>  $city->district->name ?? '—',
                    'status' => $city->status,
                    'status_label' => $city->deleted_at ? 'Deleted' : 'Active',
                    'deleted_at' => $city->deleted_at,
                    'actions' => $city->id
                ];
            });

        return DataTables::of($cities)->make(true);
    }

    public function getCities($districtId)
    {
    $cities = City::where('district_id', $districtId)->get();

    return response()->json($cities);
    }
}
