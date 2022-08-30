<?php

namespace App\Http\Requests;

class StoreAdItemRequest extends \Illuminate\Foundation\Http\FormRequest
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
            'name' => 'required',
            'type_id' => 'required',
            'duration'=> 'required'


        ];
    }

    public function messages()
    {
        return [
            'name.*' => 'Please add name.',
            'videoFile.*' => 'Maximum allowed size is 2gb.'

        ];
    }

}
