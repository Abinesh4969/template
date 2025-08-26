<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterRequest extends FormRequest
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
         return [
            'unique_code' => 'required|string|unique:users,unique_code',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
            // 'role' => 'nullable|in:user,broker',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'country_of_residence' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];

    }

    public function messages(): array
    {
        return [
        'unique_code.required' => 'Please enter the unique code.',
        'unique_code.unique' => 'This unique code is already registered.',
        'name.required' => 'Please enter your name.',
        'phone.required' => 'Please provide a phone number.',
        'phone.digits' => 'Phone number must be exactly 10 digits.',
        'phone.unique' => 'This phone number is already registered.',
        'email.email' => 'Please provide a valid email address.',
        'email.unique' => 'This email is already in use.',
        'password.required' => 'Please enter a password.',
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        'password.min' => 'Password must be at least 8 characters.',
        'role.required' => 'Please specify the role.',
        'role.in' => 'Role must be one of: user, dealer, employee.',
        'dob.required' => 'Date of birth is required.',
        'gender.in' => 'Gender must be male, female, or other.',
        'nationality.required' => 'Please provide your nationality.',
        'country_of_residence.required' => 'Please provide your country of residence.',
        'image.image' => 'Please upload a valid image file.',
        'image.mimes' => 'Image must be a jpeg, png, jpg, or svg.',
        'image.max' => 'Image size must not exceed 2MB.',
    ];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422)
        );
    }

    
}
