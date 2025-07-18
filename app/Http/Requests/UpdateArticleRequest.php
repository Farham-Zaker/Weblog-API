<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'article_id' => ['required', 'exists:articles,id'],
            'title' => ['string', 'max:255'],
            'body' => ['string']
        ];
    }

    public function messages(): array
    {
        return [
            'article_id.required' => 'Article ID is required.',
            'article_id.exists' => 'The specified article does not exist.',
            'title.max' => 'The title may not be greater than 255 characters.',
        ];
    }
}
