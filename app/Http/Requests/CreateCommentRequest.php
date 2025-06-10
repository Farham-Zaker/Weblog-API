<?php

namespace App\Http\Requests;

use App\Http\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCommentRequest extends FormRequest
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
            'comment'     => 'required|string|min:3|max:1000',
            'article_id'  => 'required|integer|exists:articles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required'     => 'Please write a comment.',
            'comment.string'       => 'The comment must be a text.',
            'comment.min'          => 'The comment must be at least 3 characters.',
            'comment.max'          => 'The comment may not be greater than 1000 characters.',

            'article_id.required'  => 'The article ID is required.',
            'article_id.integer'   => 'The article ID must be a number.',
            'article_id.exists'    => 'The selected article does not exist.',
        ];
    }
    public function failedValidation(Validator $validation)
    {
        $response = ApiResponse::error(422, "Validation failed", $validation->errors());
        throw new HttpResponseException($response);
    }
}
