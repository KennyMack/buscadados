<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCategoriesFormRequest extends Request
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
            'name' => 'required|unique:category|max:255',
            'orderby' =>'required|Integer',
            'type' =>'required',
            'readonlyname' =>'required|Integer',
            'readonlydescription' =>'required|Integer',
            'isactive' => 'required',
        ];
    }
}
