<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserFormRequest extends Request
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
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->id,
            'type' => 'max:255',
            'isactive' => 'max:255',
            'firstlogin' => 'max:255',
            'password' => 'min:6|confirmed',
        ];
    }
}
