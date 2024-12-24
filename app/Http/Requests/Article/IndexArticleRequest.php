<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ResponsesTrait;
use Illuminate\Contracts\Validation\Validator;
class IndexArticleRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'category_id' => 'nullable|uuid|exists:categories,id',
            'author_id' => 'nullable|uuid|exists:authors,id',
            'source_id' => 'nullable|uuid|exists:sources,id',
            'published_at' => 'nullable|date',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
