<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'       => 'required|email',
            'unique_code' => 'required|string',
            'password'    => 'required|string',
            // 'role'     => 'required|in:user,dealer,employee',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'       => 'Please provide your email address.',
            'email.email'          => 'Please enter a valid email address.',
            'unique_code.required' => 'Unique code is required.',
            'password.required'    => 'Please enter your password.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email       = $this->input('email');
            $unique_code = $this->input('unique_code');
            $password    = $this->input('password');
            $role        = $this->input('role');

            if ($email && $unique_code && $password) {  
                $user = User::where('email', $email)
                            ->where('unique_code', $unique_code)
                            ->when($role, fn($q) => $q->where('role', $role))
                            ->first();

                if (!$user) {
                    $validator->errors()->add('email', 'No account found with this email and unique code.');
                } elseif (!Hash::check($password, $user->password)) {
                    $validator->errors()->add('password', 'The password you entered is incorrect.');
                }
            }
        });
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
