<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
        
            'company_name' => 'required|unique:people',
            'tin_number' => 'nullable|unique:people|numeric',
            'email' => 'nullable|unique:people',
            'name' => 'required',
            'user_id' => 'required',
            
            'statu'=> 'required',
            'source'=> 'required',
       
            'created_by' => 'required',
            'rating' => 'required',
            'Landline' => 'unique:people|nullable|numeric',
            'mobile_number' => 'unique:people|nullable|numeric',
            'tin_number' =>'nullable|unique:people|numeric',
       
            
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
