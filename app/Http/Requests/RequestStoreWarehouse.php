<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreWarehouse extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all authenticated users to make this request
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
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'regex:/^\d{5}$/'], // Assuming a 5-digit zip code
            'country' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'regex:/^\d{10,15}$/', 'unique:warehouses,phone,' . ($this->warehouse ? $this->warehouse->id : null)], // Assuming phone number between 10 and 15 digits
            'email' => ['required', 'email', 'max:255', 'unique:warehouses,email,' . ($this->warehouse ? $this->warehouse->id : null)],
            'is_active' => ['required', 'boolean'],
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
            'name.required' => 'The warehouse name is required.',
            'name.min' => 'The warehouse name must be at least 2 characters long.',
            'address.required' => 'The address is required.',
            'city.required' => 'The city is required.',
            'state.required' => 'The state is required.',
            'zip_code.required' => 'The zip code is required.',
            'zip_code.regex' => 'The zip code must be exactly 5 digits.',
            'country.required' => 'The country is required.',
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be between 10 and 15 digits.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be valid.',
            'is_active.required' => 'The status is required.',
            'is_active.boolean' => 'The status must be either active or inactive.',
        ];
    }
}

