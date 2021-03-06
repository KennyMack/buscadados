<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateCategoriesFormRequest extends Request
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
            'name' => 'required|unique:category,name,'.$this->id.'|max:255',
            'orderby' =>'required|Integer',
            'type' =>'required',
            'icon'=> 'required|numeric|min:1|max:9',
            //'readonlyname' =>'required|Integer',
            //'readonlydescription' =>'required|Integer',
            'isactive' => 'required',
        ];
    }
}
