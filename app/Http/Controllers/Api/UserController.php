<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    
     public function updateProfile(Request $request): JsonResponse
    {
        $user = auth()->user();

      
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
                'sometimes',
                'filled',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'address' => 'sometimes|nullable|string',
            'image' => 'sometimes|image|max:2048',
        ], [
            'phone.regex' => 'Phone number must include a valid country code (e.g., +91).'
        ]);


        $updateData = [];

    if ($request->filled('name')) {
        $updateData['name'] = $request->name;
    }
    if ($request->filled('phone')) {
        $updateData['phone'] = $request->phone;
    }
    if ($request->filled('email')) {
        $updateData['email'] = $request->email;
    }
    if ($request->filled('address')) {
        $updateData['address'] = $request->address;
    }

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
            'message' => 'Profile updated successfully',
            'data' => [
                'name' => $user->name,
                'mobile_number' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
                'image_url' => $imageUrl,
            ]
        ]);
    }

    public function getUserProfile(): JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $media = $user->getFirstMedia('profile_image');
        $imageUrl = $media 
        ? asset('storage/app/public/' . $media->id . '/' . $media->file_name)
        : asset('app-assets/images/unkownimage.png');
        
        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'mobile_number' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
                'image_url' => $imageUrl,
                // 'created_at' => $user->created_at,
                // 'updated_at' => $user->updated_at,
            ]
        ]);
    }

}
