<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlantRequest extends FormRequest
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
            'plant_type_id' => 'required',
            'name' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desc' => 'required',
            'bellow_temperature' => 'required',
            'top_temperature' => 'required',
        ];
    }
    
    /**
     * @Override
     */
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'validator' => $validator->errors(),
            ], 422)
        );
    }


}
