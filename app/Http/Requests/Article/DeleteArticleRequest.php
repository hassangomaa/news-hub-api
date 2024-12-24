<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class DeleteArticleRequest extends ShowArticleRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return $rules;
    }
}
