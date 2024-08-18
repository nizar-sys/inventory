<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreCategory extends FormRequest
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
            'code' => [
                'required',
                'string',
                'min:2',
                'unique:categories,code,' . ($this->category ? $this->category->id : null) // Assuming 'categories' is your table name
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255' // You can adjust the maximum length as needed
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Code is required',
            'code.string' => 'Code must be a string',
            'code.min' => 'Code must be at least :min characters',
            'code.unique' => 'Code has already been taken',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.min' => 'Name must be at least :min characters',
            'name.max' => 'Name may not be greater than :max characters',
        ];
    }
}
