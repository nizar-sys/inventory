<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreSupplier extends FormRequest
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
            'branch_id' => [
                'required',
                'exists:warehouses,id', // Ensure branch_id exists in branches table
            ],
            'name' => [
                'required',
                'string',
                'min:2', // Minimum length of 2 characters
            ],
            'contact' => [
                'required',
                'string',
                'regex:/^[\w\s]+$/', // Adjust the regex pattern as needed for contact
                'unique:suppliers,contact,' . ($this->supplier ? $this->supplier->id : null)
            ],
            'address' => [
                'required',
                'string',
                'min:5', // Minimum length of 5 characters
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
            'branch_id.required' => 'Branch is required',
            'branch_id.exists' => 'Branch does not exist',
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters',
            'contact.required' => 'Contact is required',
            'contact.regex' => 'Contact must be alphanumeric',
            'address.required' => 'Address is required',
            'address.min' => 'Address must be at least 5 characters',
        ];
    }
}
