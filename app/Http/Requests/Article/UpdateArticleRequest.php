<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ResponsesTrait;
use Illuminate\Contracts\Validation\Validator;
class UpdateArticleRequest extends CreateArticleRequest
{


    use ResponsesTrait;

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->failed(null, $validator->errors()->first()));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['url'] = 'required|url|unique:articles,url,' . $this->route('id'); // Allow the same URL for the current article
        return $rules;
    }
}
