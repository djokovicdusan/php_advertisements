<?php

namespace App\Http\Requests;

class StoreAdRequest extends \Illuminate\Foundation\Http\FormRequest
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
