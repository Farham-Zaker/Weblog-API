<?php

namespace App\Http\Requests;

use App\Http\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateCommentRequest extends FormRequest
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
            'comment_id'    => 'required|exists:comments,id',
            'comment'       => 'required|string|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            "comment_id.required" => "The comment ID is required.",
            "comment_id.exists" => "There is no comment with such ID.",
            "comment.required" => "Please write a comment.",
            "comment.string" => "The comment must be a text.",
            "comment.min" => "The comment must be at least 1 character.",
        ];
    }
    public function failedValidation(Validator $validation)
    {
        $response = ApiResponse::error(422, "Validation failed", $validation->errors());
        throw new HttpResponseException($response);
    }
}
