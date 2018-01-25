<?php

namespace App\Http\Requests\Ajax;

use Illuminate\Foundation\Http\FormRequest;

class Merchandise extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'store_id' => 'integer',
            'category_id' => 'integer',
            'status' => 'in:TAKEN_OFF,ON_SHELVES',
            'products' => 'products',
            'stock_num' => 'integer|min:0',
            'name' => 'required|string',
            'sell_price' => 'required||min:0',
            'prime_price' => 'max:0',
            'images' => 'images',
            'brief_introduction' => 'string',
            'content' => 'string',
            'spec_array' => 'spec_array'
        ];
    }
}
