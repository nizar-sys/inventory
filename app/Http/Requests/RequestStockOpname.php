<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStockOpname extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'stock_in' => 'nullable|integer|min:0',
            'stock_out' => 'nullable|integer|min:0',
            'actual_stock' => 'required|integer|min:0',
        ];
    }
}
