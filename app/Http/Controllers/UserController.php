<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
class UserController extends Controller
{

    
    public function index(Request $request)
    {

         return view('admin.users.index');

    }
       public function create(Request $request)
    {

         return view('admin.users.create');

    }
    
    public function show($id){

        $user = User::with(['media'])
        ->find($id);

        // Check if the user exists
        if (!$user) {
        return redirect()->route('admin.users.index')->with('error', 'User not found');
        }

        // Return a view with the user data
        return view('admin.users.show', compact('user'));
        

    }
    public function store(RegisterRequest $request)
    {

        $user = new User();
        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->password             = bcrypt($request->password);
        $user->unique_code          = $request->unique_code;
        $user->nationality          = $request->nationality;
        $user->country_of_residence = $request->country_of_residence;
        $user->dob                  = $request->dob;
        $user->gender               = $request->gender;
        $user->role                 = 'user';
        $user->save();
        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('profile_image');
        }
        $user->assignRole('user'); 
        return response()->json(['message' => 'User created successfully.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // includes soft deleted
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id); // Include soft deleted if needed

        $request->validate([
            'name' => 'sometimes|filled|string|max:255',
            'phone' => [
                'sometimes',
                'filled',
                'string',
                'regex:/^\+[1-9]\d{1,14}$/',
                Rule::unique('users', 'phone')->ignore($user->id),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'address' => 'sometimes|nullable|string',
            'image' => 'sometimes|image|max:2048',
        ], [
            'phone.regex' => 'Phone number must include a valid country code (e.g., +91).'
        ]);

        $updateData = [];

        if ($request->filled('name'))    $updateData['name']    = $request->name;
        if ($request->filled('phone'))   $updateData['phone']   = $request->phone;
        if ($request->filled('email'))   $updateData['email']   = $request->email;
        if ($request->filled('address')) $updateData['address'] = $request->address;

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        if ($request->hasFile('image')) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('image')->toMediaCollection('profile_image');
        }

        $media = $user->getFirstMedia('profile_image');
        $imageUrl = $media
            ? asset('storage/app/public/' . $media->id . '/' . $media->file_name)
            : asset('app-assets/images/unkownimage.png');

        return response()->json([
            'success' => true,
            'message' => 'User profile updated successfully.',
            'data' => [
                'name' => $user->name,
                'mobile_number' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
                'image_url' => $imageUrl,
            ]
        ]);
    }

    public function destroy($id)
    {
        $User = User::findOrFail($id);

        $User->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
     

    public function userdata()
    {
              $users = User::with(['media'])->where('role','user')
                ->select(['id', 'name', 'email', 'phone', 'created_at'])
                ->get()
                ->map(function ($user) {
                    
                    $media = $user->getFirstMedia('profile_image');
                    $imageUrl = $media ? asset('storage/app/public/' . $media->id . '/' . $media->file_name) : asset('app-assets/images/logo/unkownimage.png');
                    $mediaId = $media ? $media->id : null;

                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'image_url' => $imageUrl,
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'actions' => $user->id 
                    ];
                });

        return DataTables::of($users)->make(true);
    }
    
    public function register(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'mobile' => 'required|digits:10|unique:users,mobile',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors()
            ], 422);
        }
      

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
        ]);
        $user->assignRole('user');
        if ($request->hasFile('profile_image')) {
            $user->addMedia($request->file('profile_image'))->toMediaCollection('images');
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'user' => $user
        ], 201);
    }




}
