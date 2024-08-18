<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Update this according to your authorization logic
        return true; // Set to true if authorization is not required
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
                'max:50', // Optional: Adjust max length as needed
                'unique:products,code,' . ($this->product ? $this->product->id : null), // Optional: Ensure code is unique in products table
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100', // Optional: Adjust max length as needed
            ],
            'category_id' => [
                'required',
                'exists:categories,id', // Ensure category_id exists in categories table
            ],
            'supplier_id' => [
                'required',
                'exists:suppliers,id', // Ensure supplier_id exists in suppliers table
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:jpeg,jpg,png', // Accept only these image formats
                'max:2048', // 2MB max size
            ],
        ];
    }

    /**
     * Customize the error messages for the validator.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.required' => 'The product code is required.',
            'code.string' => 'The product code must be a string.',
            'code.min' => 'The product code must be at least 2 characters long.',
            'code.max' => 'The product code may not be greater than 50 characters.',
            'code.unique' => 'The product code has already been taken.',
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.min' => 'The product name must be at least 2 characters long.',
            'name.max' => 'The product name may not be greater than 100 characters.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'supplier_id.required' => 'The supplier is required.',
            'supplier_id.exists' => 'The selected supplier is invalid.',
            'image.file' => 'The image must be a file.',
            'image.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'image.max' => 'The image may not be greater than 2MB.',
        ];
    }
}
