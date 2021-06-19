<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersoncreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required|unique:people',
            'name' => 'required',
            'statu'=> 'required',
            'source'=> 'required',
            'rating' => 'required',
            'phone_number' => 'min:0|max:10|unique:people',
            'mobile_number' => 'min:0|max:10|unique:people',
            'tin_number' => 'min:0|max:10'
        ];
    }
}
