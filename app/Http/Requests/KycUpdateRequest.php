<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class KycUpdateRequest extends FormRequest
{ 
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user(); // Current authenticated user
        $role = $user->role;

        // Common file rules
        $fileRule = ['file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];

      return [
            'government_id_type' => 'required|in:aadhaar,national_id,passport,driver_license,voter_id,pan,other',
            'government_id_number' => 'required|string|max:255',
            'tax_id' => 'required|string|max:255',
            'address_line' => 'required|string|max:255',

            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'city_id' => 'required|exists:cities,id',
            'postal_code' => 'required|string|max:20',

            'government_id_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'proof_of_address_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'live_selfie_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'partnership_agreement_file' => 'required|file|mimes:pdf|max:10240',
            'contracts_file' => 'required|file|mimes:pdf|max:10240',
            'nda_file' => 'required|file|mimes:pdf|max:10240',
        ];
        return $rules;
    }


    public function messages(): array
    {
        return [
            'aadhaar.required' => 'Aadhaar image is required.',
            'pan_card.required' => 'PAN card is required for dealers.',
            'gst_certificate.required' => 'GST certificate is required for dealers.',
            'upi_id.required' => 'Please enter your UPI ID.',
            'upi_mobile.required' => 'UPI mobile number is required.',
        ];
    }

        protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422)
        );
    }
}
