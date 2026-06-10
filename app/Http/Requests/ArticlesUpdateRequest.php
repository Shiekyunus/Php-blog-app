<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArticlesUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    // Define the validation rules for updating an article, including title, body, category, tags, and image.
    public function rules(): array
    {
        return [
            //
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
    // Define custom error messages for validation failures.
    public function message(): array
    {
        return[
            'title.required' => 'Article title is required',
            'body.required' => 'content field is required',
        ];
    }
}
