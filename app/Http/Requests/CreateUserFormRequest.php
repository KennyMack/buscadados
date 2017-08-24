<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserFormRequest extends Request
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
            'email' => 'required|email|max:255|unique:users',
            'type' => 'max:255',
            'isactive' => 'max:255',
            'firstlogin' => 'max:255',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
