<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuiderRequest extends FormRequest
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
            'code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'code.required' => '缺少CODE授权码'
        ];
    }
}
