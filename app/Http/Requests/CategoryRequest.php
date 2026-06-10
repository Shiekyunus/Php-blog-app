<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
    //  Define the validation rules for creating or updating a category, ensuring the name is required, unique, and has a maximum length, while the description is optional.
    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;
        return [
            //
            'name' => 'required|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string',
        ];
    }
    // Define custom error messages for validation failures, providing specific feedback for required and unique name fields.
    public function message()
    {
        return [
            'name.required' => 'Category name is required. ',
            'name.unique'  => 'Category name already exists. '
        ];
    }
}
