<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PersonupdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       
        return [
        
            'company_name' => 'required',
            'name' => 'required',
            'statu'=> 'required',
            'source'=> 'required',
            'rating' => 'required',
            'phone_number' => 'min:0|max:10',
            'mobile_number' => 'min:0|max:10',
            'tin_number' => 'min:0|max:10'
            
        ];
    
}
    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
       
        ];
    }
}
