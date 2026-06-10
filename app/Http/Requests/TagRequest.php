<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
    // Define the validation rules for creating or updating a tag, ensuring the name is required, unique, and has a maximum length.
    public function rules(): array
    {
        $tagId = $this->route('tag') ? $this->route('tag')->id : null;
        return [
            //
            'name' => 'required|max:255|unique:tags,name,'.$tagId,

        ];
    }
    // Define custom error messages for validation failures, providing specific feedback for required and unique name fields.
    public function message(): array
    {
        return[
              'name.required' => 'Tag name is required.',
              'name.unique' => 'Tag already exists.',
        ];
    }
}
