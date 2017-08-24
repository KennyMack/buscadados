<?php

namespace App\Http\Requests\Company\Register;

use App\Http\Requests\Request;

class RegisterAddressFormRequest extends Request
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

    public function messages()
    {
        return [
            'city_id.min' => 'Selecione a cidade.',
            'city_id.required' => 'Selecione a cidade.',
            'city_id.integer' => 'Selecione a cidade.',
            'state_id.min' => 'Selecione o estado.',
            'state_id.required' => 'Selecione o estado.',
            'state_id.integer' => 'Selecione o estado.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => 'required|min:0|integer',
            'state_id' => 'required|min:0|integer',
            'address' => 'required|min:2|max:255',
            'number' => 'required|max:15',
            'postalnumber' => 'required|min:2|max:15',
            'district' => 'required|min:2|max:60',
        ];
    }
}
