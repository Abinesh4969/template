<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingDirection;
use App\Models\ConstructionStatus;
use App\Models\FurnishingType;
use App\Models\ListedBy;
use App\Models\MaintenanceFrequency;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\PropertyType;
use App\Models\PropertyMethod;
use App\Models\BikeBrand;
use App\Models\BikeModel;
use App\Models\ElectronicBrand;
use App\Models\ElectronicModel;
use App\Models\Property;
use App\Models\Car;
use App\Models\Bike;
use App\Models\Electronic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
class DropdownController extends Controller
{
    public function getVendorProfile($vendorId)
    {
        $vendor = User::findOrFail($vendorId);

        $media = $vendor->getFirstMedia('profile_image');

        return response()->json([
        'id'            => $vendor->id,
        'name'          => $vendor->name,
        'email'         => $vendor->email,
        'phone'         => $vendor->phone, 
        'profile_image' => $media ? asset('storage/app/public/' . $media->id . '/' . $media->file_name) : asset('app-assets/images/unkownimage.png'),
        ]);
    }
     public function getBuildingDirections()
    {
        return response()->json([
            'status' => true,
            'data' => BuildingDirection::where('active', 1)->get()
        ]);
    }

    public function getConstructionStatuses()
    {
        return response()->json([
            'status' => true,
            'data' => ConstructionStatus::where('active', 1)->get()
        ]);
    }

    public function getFurnishingTypes()
    {
        return response()->json([
            'status' => true,
            'data' => FurnishingType::where('active', 1)->get()
        ]);
    }

    public function getListedBy()
    {
        return response()->json([
            'status' => true,
            'data' => ListedBy::where('active', 1)->get()
        ]);
    }

    public function getMaintenanceFrequencies()
    {
        return response()->json([
            'status' => true,
            'data' => MaintenanceFrequency::where('active', 1)->get()
        ]);
    }

    // Realted
     public function getStates()
    {
        $states = State::where('status', 1)->get();

        return response()->json([
            'status' => true,
            'data' => $states
        ]);
    }

    public function getDistricts(Request $request) 
    {
        $request->validate([
            'state_id' => 'required|integer|exists:states,id'
        ]);

        $districts = District::where('state_id', $request->state_id)
                            ->where('status', 1)
                            ->get();

        return response()->json($districts);
    }
   
    public function getCitiesByDistrict(Request $request)
    {
        $request->validate([
            'district_id' => 'required|integer|exists:districts,id'
        ]);

        $cities = City::where('district_id', $request->district_id)
                    ->where('status', 1)
                    ->get();

        return response()->json($cities);
    }

     public function getPropertyTypesBySubcategory()
    {
        $types = PropertyType::with('subcategory:id,name')
        ->where('active', 1)
        ->get(['id', 'name', 'subcategory_id'])
        ->map(function ($type) {
        return [
            'id' => $type->id,
            'name' => $type->name,
            'subcategory_name' => $type->subcategory->name ?? null
        ];
        });

        return response()->json([
        'status' => true,
        'data' => $types
        ]);

    }

    // Get Property Methods by Property Type ID
    public function getPropertyMethodsByType($typeId)
    {
        $methods = PropertyMethod::where('property_type_id', $typeId)
                                 ->where('active', 1)
                                 ->get();

        return response()->json([
            'status' => true,
            'data' => $methods
        ]);
    }

      public function getbhk()
    {
        $bhks = \App\Models\Bhk::where('active', true)->get();
        return response()->json([
            'status' => true,
            'data' => $bhks
        ]);
    }
    
    // car dropdown
    public function carbrands()
    {
        $brands = \App\Models\CarBrand::where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        $brands[] = ['id' => 'other', 'name' => 'other'];
        return response()->json([
            'message' => 'Car brands fetched successfully.',
            'data' => $brands
        ]);
    }

    public function carmodelsByBrand(Request $request)
    {
        $brandId = $request->input('brand_id');

        $models = \App\Models\CarModel::where('car_brand_id', $brandId)
            ->where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        $models[] = ['id' => 'other', 'name' => 'other'];
        return response()->json([
            'message' => 'Car models fetched successfully.',
            'data' => $models
        ]);
    }

    public function fuelTypes()
    {
        $fuelTypes = \App\Models\FuelType::where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'message' => 'Fuel types fetched successfully.',
            'data' => $fuelTypes
        ]);
    }

    public function transmissions()
    {
        $transmissions = \App\Models\Transmission::where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'message' => 'Transmissions fetched successfully.',
            'data' => $transmissions
        ]);
    }

    public function owners()
    {
        $owners = \App\Models\NumberOfOwner::where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'message' => 'Number of owners fetched successfully.',
            'data' => $owners
        ]);
    }


    // end car

    //start bike 
    public function bikeBrands()
    {
        $brands = BikeBrand::where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

            $brands[] = ['id' => 'other', 'name' => 'other'];

        return response()->json([
            'message' => 'Bike brands fetched successfully.',
            'data' => $brands
        ]);
    }

    public function bikeModelsByBrand(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
        ]);

        $models = BikeModel::where('bike_brand_id', $request->brand_id)
            ->where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

            $models[] = ['id' => 'other', 'name' => 'other'];

        return response()->json([
            'message' => 'Bike models fetched successfully.',
            'data' => $models
        ]);
    }
    //end bike

    public function electronicsbrands(Request $request)
    {
        $query = ElectronicBrand::where('active', 1);

        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        $brands = $query->select('id', 'name')->orderBy('name')->get();

        // Add "other" option
        $brands->push([
            'id' => 'other',
            'name' => 'Other',
        ]);

        return response()->json([
            'message' => 'Electronics brands fetched successfully.',
            'data' => $brands
        ]);
    }


    public function electronicsmodelsByBrand(Request $request)
    {

        
        $request->validate([
            'brand_id' => 'required',
        ]);

        $models = ElectronicModel::where('electronic_brand_id', $request->brand_id)
            ->where('active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $models[] = ['id' => 'other', 'name' => 'other'];
        
        return response()->json([
            'message' => 'Electronics models fetched successfully.',
            'data' => $models
        ]);
    }
    //end bike

    // 
public function allListingsApi(Request $request): JsonResponse
{
    $perPage = $request->get('per_page', 9); // Default to 9
    $page = $request->get('page', 1);
    
    // Get distance limit
    $distanceLimit = \App\Models\Distance::first()->kilomitar ?? 10;
    
    // Collect all listings
    $allListings = collect();
    
    // Get Properties
    $properties = \App\Models\Property::with([
        'media', 'subcategory', 'city', 'state', 'district', 'furnished',
        'bhk', 'listedBy', 'maintenance', 'buildingDirection'
    ])->where('status', 'available')
      ->where('is_published', 1)
      ->latest()
      ->get();
    
    // Transform properties
    $transformedProperties = $properties->map(function ($property) {
        $imageMedia = $property->getFirstMedia('property_images');
        $videoMedia = $property->getFirstMedia('property_videos');
        
        return [
            'id' => $property->id,
            'type' => 'property',
            'title' => $property->property_name,
            'property_name' => $property->property_name,
            'mobile_number' => $property->mobile_number,
            'bedrooms' => $property->bedrooms,
            'unique_code' => $property->unique_code,
            'action_slug' => $property->slug,
            'bathroom' => $property->bathroom, 
            'furnished' => $property->furnished->name ?? null,
            'furnished_id' => $property->furnished_id,
            'subcategory' => $property->subcategory->name ?? null,
            'slug' => $property->subcategory->slug ?? "default",
            'form_type' => $property->subcategory->category->name ?? null,
            'subcategory_id' => $property->subcategory_id,
            'state' => $property->state->name ?? null,
            'state_id' => $property->state_id,
            'district' => $property->district->name ?? null,
            'district_id' => $property->district_id,
            'city' => $property->city->name ?? null,
            'city_id' => $property->city_id,
            'maintenance' => $property->maintenance->name ?? null,
            'maintenance_id' => $property->maintenance_id,
            'listed_by' => $property->listedBy->name ?? null,
            'listed_by_id' => $property->listed_by,
            'bhk' => $property->bhk->name ?? null,
            'bhk_id' => $property->bhk_id,
            'building_direction' => $property->buildingDirection->name ?? null,
            'building_direction_id' => $property->building_direction_id,
            'address' => $property->address,
            'description' => $property->description,
            'super_builtup_area' => $property->super_builtup_area,
            'carpet_area' => $property->carpet_area,
            'floor_no' => $property->floor_no,
            'total_floors' => $property->total_floors,
            'car_parking' => $property->car_parking,
            'bike_parking' => $property->bike_parking,
            'wash_room' => $property->wash_room,
            'bachelor' => $property->bachelor,
            'construction_status_id' => $property->construction_status_id,
            'construction_status_name' => $property->constructionStatus->name ?? null,
            'plot_area' => $property->plot_area,
            'length' => $property->length,
            'breadth' => $property->breadth, // Standardized price field
            'price' => number_format($property->amount, 2),
            'amount' => number_format($property->amount, 2),
            'status' => $property->status,
            'post_date' => date('d-M-y', strtotime($property->created_at)), // e.g., 05-Jun-24
            'post_year' => date('Y', strtotime($property->created_at)),  
            'is_published' => $property->is_published,
            'image_url' => $imageMedia
                ? asset('storage/app/public/' . $imageMedia->id . '/' . $imageMedia->file_name)
                : asset('app-assets/images/unkownimage.png'),
            'video_url' => $videoMedia
                ? asset('storage/app/public/' . $videoMedia->id . '/' . $videoMedia->file_name)
                : asset('app-assets/images/unkownimage.png'),
            'status_label' => $property->deleted_at ? 'Deleted' : 'Active',
            'deleted_at' => $property->deleted_at,
            'created_at' => $property->created_at,
            'updated_at' => $property->updated_at,
        ];
    });
    
    // Get Cars
    $cars = Car::with([
        'media', 'brand', 'model', 'fuelType', 'transmission', 'numberOfOwner',
        'city', 'district', 'state', 'subcategory'
    ])->where('status', 'available')
      ->where('is_published', 1)
      ->latest()
      ->get();
    
    // Transform cars
    $transformedCars = $cars->map(function ($car) {
        $imageMedia = $car->getFirstMedia('car_images');
        $videoMedia = $car->getFirstMedia('car_videos');
        
        return [
            'id' => $car->id,
            'type' => 'car',
            'title' => $car->title,
            'form_type' => 'car',
            'unique_code' => $car->unique_code,
            'action_slug' => $car->slug,
            'brand_name' => $car->brand_name,
            'model_name' => $car->model_name,
            'brand' => $car->brand->name ?? null,
            'brand_id' => $car->brand_id,
            'model' => $car->model->name ?? null,
            'model_id' => $car->model_id,
            'subcategory' => $car->subcategory->name ?? null,
            'subcategory_id' => $car->subcategory_id,
            'year' => $car->year,
            'kilometers' => $car->kilometers,
            'fuel_type' => $car->fuelType->name ?? null,
            'fuel_type_id' => $car->fuel_type_id,
            'transmission' => $car->transmission->name ?? null,
            'transmission_id' => $car->transmission_id,
            'number_of_owner' => $car->numberOfOwner->name ?? null,
            'number_of_owner_id' => $car->number_of_owner_id,
            'price' => number_format($car->price, 2),
            'description' => $car->description,
            'status' => $car->status,
            'state' => $car->state->name ?? null,
            'state_id' => $car->state_id,
            'district' => $car->district->name ?? null,
            'district_id' => $car->district_id,
            'city' => $car->city->name ?? null,
            'city_id' => $car->city_id,
            'address' => $car->address,
            'mobile_number' => $car->mobile_number,
            'is_published' => $car->is_published,
            'latitude' => $car->latitude,
            'longitude' => $car->longitude,
            'image_url' => $imageMedia
                ? asset('storage/app/public/' . $imageMedia->id . '/' . $imageMedia->file_name)
                : null,
            'video_url' => $videoMedia
                ? asset('storage/app/public/' . $videoMedia->id . '/' . $videoMedia->file_name)
                : null,
            'status_label' => $car->deleted_at ? 'Deleted' : 'Active',
            'deleted_at' => $car->deleted_at,
            'created_at' => $car->created_at,
            'updated_at' => $car->updated_at,
        ];
    });
    
    // Get Bikes
    $bikes = Bike::with([
        'media', 'brand', 'model', 'city', 'district', 'state', 'subcategory'
    ])->where('status', 'available')
      ->where('is_published', 1)
      ->latest()
      ->get();
    
    // Transform bikes
    $transformedBikes = $bikes->map(function ($bike) {
        $imageMedia = $bike->getFirstMedia('bike_images');
        $videoMedia = $bike->getFirstMedia('bike_videos');
        
        return [
            'id' => $bike->id,
            'type' => 'bike',
            'title' => $bike->title,
            'form_type' => 'bike',
            'unique_code' => $bike->unique_code,
            'action_slug' => $bike->slug,
            'brand_name' => $bike->brand_name,
            'model_name' => $bike->model_name,
            'brand' => $bike->brand->name ?? null,
            'brand_id' => $bike->brand_id,
            'model' => $bike->model->name ?? null,
            'model_id' => $bike->model_id,
            'subcategory' => $bike->subcategory->name ?? null,
            'slug' => $bike->subcategory->slug ?? "default",
            'subcategory_id' => $bike->subcategory_id,
            'engine_cc' => $bike->engine_cc,
            'year' => $bike->year,
            'kilometers' => $bike->kilometers,
            'price' => number_format($bike->price, 2),
            'description' => $bike->description,
            'status' => $bike->status,
            'state' => $bike->state->name ?? null,
            'state_id' => $bike->state_id,
            'district' => $bike->district->name ?? null,
            'district_id' => $bike->district_id,
            'city' => $bike->city->name ?? null,
            'city_id' => $bike->city_id,
            'address' => $bike->address,
            'mobile_number' => $bike->mobile_number,
            'is_published' => $bike->is_published,
            'latitude' => $bike->latitude,
            'longitude' => $bike->longitude,
            'image_url' => $imageMedia
                ? asset('storage/app/public/' . $imageMedia->id . '/' . $imageMedia->file_name)
                : null,
            'video_url' => $videoMedia
                ? asset('storage/app/public/' . $videoMedia->id . '/' . $videoMedia->file_name)
                : null,
            'status_label' => $bike->deleted_at ? 'Deleted' : 'Active',
            'deleted_at' => $bike->deleted_at,
            'created_at' => $bike->created_at,
            'updated_at' => $bike->updated_at,
        ];
    });
    
    // Get Electronics
    $electronics = Electronic::with([
        'media', 'brand', 'model', 'city', 'district', 'state', 'subcategory'
    ])->where('status', 'available')
      ->where('is_published', 1)
      ->latest()
      ->get();
    
    // Transform electronics
    $transformedElectronics = $electronics->map(function ($electronic) {
        $imageMedia = $electronic->getFirstMedia('electronic_images');
        $videoMedia = $electronic->getFirstMedia('electronics_videos');
        
        return [
            'id' => $electronic->id,
            'type' => 'electronics',
            'title' => $electronic->title,
            'form_type' => 'electronics',
            'unique_code' => $electronic->unique_code,
            'action_slug' => $electronic->slug,
            'year' => $electronic->year,
            'brand_name' => $electronic->brand_name,
            'model_name' => $electronic->model_name,
            'brand' => $electronic->brand->name ?? null,
            'brand_id' => $electronic->brand_id,
            'model' => $electronic->model->name ?? null,
            'model_id' => $electronic->model_id,
            'subcategory' => $electronic->subcategory->name ?? null,
            'subcategory_id' => $electronic->subcategory_id,
            'price' => number_format($electronic->price, 2),
            'description' => $electronic->description,
            'features' => $electronic->features,
            'specifications' => $electronic->specifications,
            'status' => $electronic->status,
            'state' => $electronic->state->name ?? null,
            'state_id' => $electronic->state_id,
            'district' => $electronic->district->name ?? null,
            'district_id' => $electronic->district_id,
            'city' => $electronic->city->name ?? null,
            'city_id' => $electronic->city_id,
            'address' => $electronic->address,
            'mobile_number' => $electronic->mobile_number,
            'is_published' => $electronic->is_published,
            'latitude' => $electronic->latitude,
            'longitude' => $electronic->longitude,
            'image_url' => $imageMedia
                ? asset('storage/app/public/' . $imageMedia->id . '/' . $imageMedia->file_name)
                : null,
            'video_url' => $videoMedia
                ? asset('storage/app/public/' . $videoMedia->id . '/' . $videoMedia->file_name)
                : null,
            'status_label' => $electronic->deleted_at ? 'Deleted' : 'Active',
            'deleted_at' => $electronic->deleted_at,
            'view_count' => $electronic->view_count ?? 0,
            'created_at' => $electronic->created_at,
            'updated_at' => $electronic->updated_at,
        ];
    });
    
    // Merge all collections using regular Collection instead of Eloquent Collection
    $allListings = collect($transformedProperties)
        ->merge($transformedCars)
        ->merge($transformedBikes)
        ->merge($transformedElectronics);
    
    // Sort by created_at (latest first)
    $allListings = $allListings->sortByDesc('created_at');
    
    // Manual pagination
    $total = $allListings->count();
    $offset = ($page - 1) * $perPage;
    $paginatedItems = $allListings->slice($offset, $perPage)->values();
    
    // Create pagination meta data
    $lastPage = ceil($total / $perPage);
    $hasMorePages = $page < $lastPage;
    
    $paginationData = [
        'current_page' => (int) $page,
        'data' => $paginatedItems,
        'first_page_url' => request()->url() . '?page=1',
        'from' => $offset + 1,
        'last_page' => (int) $lastPage,
        'last_page_url' => request()->url() . '?page=' . $lastPage,
        'next_page_url' => $hasMorePages ? request()->url() . '?page=' . ($page + 1) : null,
        'path' => request()->url(),
        'per_page' => (int) $perPage,
        'prev_page_url' => $page > 1 ? request()->url() . '?page=' . ($page - 1) : null,
        'to' => min($offset + $perPage, $total),
        'total' => $total,
    ];
    
    return response()->json([
        'success' => true,
        'message' => 'All listings fetched successfully',
        'data' => $paginationData,
     
    ]);
}

}
