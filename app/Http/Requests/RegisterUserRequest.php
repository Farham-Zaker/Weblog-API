<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUserRequest extends FormRequest
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
            'username'   => 'required|string|min:5|max:255|unique:users,username',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6',

        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'username.string'   => 'Username must be a string.',
            'username.min'      => 'Username must be at least 5 characters.',
            'username.max'      => 'Username must not exceed 255 characters.',

            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already taken.',

            'password.required' => 'Password is required.',
            'password.string'   => 'Password must be a string.',
            'password.min'      => 'Password must be at least 6 characters.',

            'reg_ip.ip'         => 'Registration IP must be a valid IP address.',
            'last_login.date'   => 'Last login must be a valid date.',
            'last_ip.ip'        => 'Last IP must be a valid IP address.',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}
