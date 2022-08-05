<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplexAdRequest extends FormRequest
{
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
        //|regex:/^[0-9+()]+$/
        // voditi racuna o tome sta je zaista required
        return [
            'itemIds' => 'required',
            'cycles' =>'required',
            'seconds' =>'required',
            'addName' => 'string|required',
            'addStart'=>'required'

        ];
    }

    public function messages()
    {
        return [
            'itemIds.*' => 'Please add name.',

        ];
    }

}
