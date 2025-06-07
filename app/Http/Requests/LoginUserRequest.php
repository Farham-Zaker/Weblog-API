<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class LoginUserRequest extends FormRequest
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
            "email"     => "required|string",
            "password"  => "required|string"
        ];
    }
    public function messages(): array
    {
        return [
            'email.required'    => 'Email is required.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
        ];
    }
    public function failedValidation(Validator $validation)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validation->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}
