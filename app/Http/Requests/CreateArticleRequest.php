<?php

namespace App\Http\Requests;

use App\Http\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255',
            'body' => 'required|string|min:20',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The article title is required.',
            'title.string' => 'The article title must be a valid string.',
            'title.min' => 'The article title must be at least 5 characters.',
            'title.max' => 'The article title may not be greater than 255 characters.',

            'body.required' => 'The article body is required.',
            'body.string' => 'The article body must be a valid string.',
            'body.min' => 'The article body must be at least 20 characters.',
        ];
    }
    public function failedValidation(Validator $validation)
    {
        $response = ApiResponse::error(422, "Validation failed", $validation->errors());
        throw new HttpResponseException($response);
    }
}
