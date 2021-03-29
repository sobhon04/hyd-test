<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapDataRequest extends FormRequest
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
            'name' => 'required|max:100',
            'mobile' => 'required|numeric|regex:/^([9]{1})([234789]{1})([0-9]{8})$/|min:10|unique:map_data,mobile',
            'email' => 'required|email|unique:map_data,email',
            'source'=>'required',
            'destination'=>'required',
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'unique.unique' => 'Email is already exists plese try another',
            'name.required' => 'Name is required!',
            'mobile.regex' => 'Enter a valid Indian mobile number',
            'mobile.required' => 'Mobile number is required!',
            'source.required'=> 'please enter your source (starting from*)',
            'destination.required'=>'please enter your destination (to*)',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'email address',
            'source' =>'Starting from',
            'destination'=>'Destination'
        ];
    }
}
