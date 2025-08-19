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

        $rules = [
            // UPI
            'upi_id' => ['required', 'string'],
            'upi_mobile' => ['required', 'digits:10'],

            // Bank Details
            'account_holder_name' => ['required', 'string'],
            'bank_name' => ['required', 'string'],
            'bank_branch' => ['required', 'string'],
            'account_number' => ['required', 'string'],
            'ifsc_code' => ['required', 'string'],

            // Aadhaar (required for all roles)
            'aadhaar' => array_merge(['required'], $fileRule),
        ];

        // Dealer-specific documents
        if ($role === 'dealer') {
            $rules['pan_card'] = array_merge(['required'], $fileRule);
            $rules['gst_certificate'] = array_merge(['required'], $fileRule);
        }

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
