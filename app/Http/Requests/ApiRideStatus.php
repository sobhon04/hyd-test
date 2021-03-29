<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRideStatus extends FormRequest
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
            'source'=>'required',
            'destination'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'source.required' => 'Please add the correct source address',
            'destination.required' => 'Please add the correct Destination address',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'errors',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
