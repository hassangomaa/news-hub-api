<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ResponsesTrait;
use Illuminate\Contracts\Validation\Validator;
class CreateArticleRequest extends FormRequest
{

    use ResponsesTrait;

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->failed(null, $validator->errors()->first()));
    }

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|unique:articles,url',
            'published_at' => 'nullable|date',
            'source_id' => 'nullable|uuid|exists:sources,id',
            'author_id' => 'nullable|uuid|exists:authors,id',
            'category_id' => 'nullable|uuid|exists:categories,id',
        ];
    }


    /**
     * Customize error messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The article title is required.',
            'title.max' => 'The article title cannot exceed 255 characters.',
            'source_id.required' => 'The source ID is required.',
            'source_id.exists' => 'The selected source does not exist.',
            'author_id.exists' => 'The selected author does not exist.',
            'category_id.exists' => 'The selected category does not exist.',
            'url.required' => 'The article URL is required.',
            'url.url' => 'The article URL must be a valid URL.',
            'url.unique' => 'This article URL has already been taken.',
            'published_at.date' => 'The publication date must be a valid date.',
        ];
    }
}
