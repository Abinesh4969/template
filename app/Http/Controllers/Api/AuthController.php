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
use Illuminate\Support\Facades\DB;
use App\Models\Kyc;
use Exception;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    { 

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        $user->assignRole('user'); 
        $user->save();
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
                'data' => [
                'status' => true,
                'unique_code' => $request->unique_code,
                'message' => 'Unique code verified. You can now access the login page.'
                ]
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
        DB::beginTransaction();

        try {
            // Check if KYC already exists for this user
            $kyc = Kyc::where('user_id', auth()->id())->first();

            if ($kyc) {
                return response()->json([
                    'status' => false,
                    'message' => 'KYC already exists. Please update instead.'
                ], 409);
            }

            // Create new KYC record
            $kyc = Kyc::create([
                'user_id'             => auth()->id(),
                'government_id_type'  => $request->government_id_type,
                'government_id_number'=> $request->government_id_number,
                'tax_id'              => $request->tax_id,
                'address_line'        => $request->address_line,
                'state_id'            => $request->state_id,
                'district_id'         => $request->district_id,
                'city_id'             => $request->city_id,
                'postal_code'         => $request->postal_code,
                'is_verified'         => false,
            ]);

            /** ---------- FILE UPLOADS ---------- **/

            // Government ID file
            if ($request->hasFile('government_id_file')) {
                $kyc->addMediaFromRequest('government_id_file')->toMediaCollection('government_id_file');
            }

            // Proof of address file
            if ($request->hasFile('proof_of_address_file')) {
                $kyc->addMediaFromRequest('proof_of_address_file')->toMediaCollection('proof_of_address_file');
            }

            // Live selfie file
            if ($request->hasFile('live_selfie_file')) {
                $kyc->addMediaFromRequest('live_selfie_file')->toMediaCollection('live_selfie_file');
            }

            // Partnership agreement file
            if ($request->hasFile('partnership_agreement_file')) {
                $kyc->addMediaFromRequest('partnership_agreement_file')->toMediaCollection('partnership_agreement_file');
            }

            // Contracts file
            if ($request->hasFile('contracts_file')) {
                $kyc->addMediaFromRequest('contracts_file')->toMediaCollection('contracts_file');
            }

            // NDA file
            if ($request->hasFile('nda_file')) {
                $kyc->addMediaFromRequest('nda_file')->toMediaCollection('nda_file');
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'KYC details submitted successfully.',
                'data' => $kyc->load('media')
            ]);

        } 
        catch (Exception $e) {
        DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to submit KYC details.',
                'error' => $e->getMessage()
            ], 500);
        }

    }



}
