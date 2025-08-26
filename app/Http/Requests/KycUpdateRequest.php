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
        $fileRule = ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];

      return [
            'government_id_type' => 'nullable|in:aadhaar,national_id,passport,driver_license,voter_id,pan,other',
            'government_id_number' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'address_line' => 'nullable|string|max:255',

            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'city_id' => 'nullable|exists:cities,id',
            'postal_code' => 'nullable|string|max:20',

            'government_id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'proof_of_address_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'live_selfie_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'partnership_agreement_file' => 'nullable|file|mimes:pdf|max:2048',
            'contracts_file' => 'nullable|file|mimes:pdf|max:2048',
            'nda_file' => 'nullable|file|mimes:pdf|max:2048',
        ];

        // Dealer-specific documents
        // if ($role === 'dealer') {
        //     $rules['pan_card'] = array_merge(['required'], $fileRule);
        //     $rules['gst_certificate'] = array_merge(['required'], $fileRule);
        // }

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
