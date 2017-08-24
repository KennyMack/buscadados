<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCompanyCategoryFormRequest extends Request
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
            'categorydetail_id' => 'required|min:0|integer',
            'imagepath' => 'max:255',
            'name' => 'required|max:120',
            'description'=> 'required|max:255',
            'value' => 'required|numeric',
            'isactive' => 'required|min:0|max:1',
        ];
    }
}
