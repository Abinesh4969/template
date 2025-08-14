<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\KycUpdateRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    { 
        
        //   $otp = rand(100000, 999999);
        $otp = 1234;

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'otp_code' => $otp,
            'otp_verified' => false,
            'kyc_verified' => false, 
        ]);

        $user->assignRole($request->role); 
        $user->otp_code = 1234;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();
        // $this->sendOtp($user->phone, $otp);

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'data' => new UserResource($user),
        ]);
    }

    public function checkUniqueCode(Request $request)
    {
        $request->validate([
            'unique_code' => 'required|string'
        ]);

        $userExists = \App\Models\User::where('unique_code', $request->unique_code)->exists();

        if ($userExists) {

            return response()->json([
                'status' => true,
                'message' => 'Unique code verified. You can now access the login page.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid unique code.'
        ], 400);
    }

    private function sendOtp($phone, $otp)
    {
        
        // OR: Use Msg91, Nexmo, or custom SMS API
    }


    public function verifyOtp(VerifyOtpRequest $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'role' => 'required|string',
            'otp' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) { 
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'OTP has expired'], 422);
        }

        if ($request->otp === $user->otp_code) {
            $user->otp_verified = true;
            $user->otp_code = null; 
            $user->otp_expires_at = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
                'otp_verified' => true,
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => new \App\Http\Resources\UserResource($user),
            ]);
        }

        return response()->json(['message' => 'Invalid OTP'], 422);
    }



    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with this email.'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password.'
            ], 401);
        }

        // if (!$user->otp_verified) {
        //     // $otp = rand(100000, 999999);
        //     $otp = 1234;
        //     // Option 1: If you're storing OTP in users table
        //     $user->otp_code = $otp;
        //     $user->otp_expires_at = now()->addMinutes(5);
        //     $user->save();

        //     return response()->json([
        //         'success' => false,
        //         'otp_required' => true,
        //         'message' => 'OTP verification required. An OTP has been sent to your phone.',
        //         'phone' => $user->phone,
        //     ], 200);
        // }

        // All good — login success
        return response()->json([
            'success' => true,
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => new \App\Http\Resources\UserResource($user),
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ]);

    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

       public function deleteacount(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }

        // Perform the deletion
        // $user->delete_requested_at = now();
        $user->delete();

        return response()->json([
            'data' => 'Account deleted successfully',
            'success' => true,
            'status' => 200,
            'message' => 'User deleted successfully.',
        ], 200);
    }

    public function updateKyc(KycUpdateRequest $request)
    {
        $user = auth()->user();

        if (!$user->otp_verified) {
                return response()->json([
                    'message' => 'You must verify your account before submitting KYC.',
                    'status' => false,
                ], 403);
            }
        $kyc = $user->kyc()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'upi_id',
                'upi_mobile',
                'account_holder_name',
                'bank_name',
                'bank_branch',
                'account_number',
                'ifsc_code',
            ])
        );

        if ($request->hasFile('aadhaar')) {
            $kyc->addMediaFromRequest('aadhaar')->toMediaCollection('aadhaar');
        }

        if ($request->hasFile('pan_card')) {
            $kyc->addMediaFromRequest('pan_card')->toMediaCollection('pan_card');
        }

            if ($request->hasFile('gst_certificate')) {
            $kyc->addMediaFromRequest('gst_certificate')->toMediaCollection('gst_certificate');
        } 
            
        return response()->json([
            'message' => 'KYC updated successfully',
            'status' => true,
        ]);
    }

}
