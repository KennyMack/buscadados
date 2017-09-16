<?php

namespace App\Http\Requests\Company\Register;

use App\Http\Requests\Request;
use App\Utils\ImageContent;

class RegisterCompanyFormRequest extends Request
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
        if (Request::file('image') != null)
            \Session::flash('image', ImageContent::imageToBase64(Request::file('image'), Request::file('image')->getMimeType()));
        else if (Request::input('imgdata'))
            \Session::flash('image', Request::input('imgdata'));

        return [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'imgdata' => 'min:0',
            'companyname' => 'required|min:2|max:120',
            'tradingname' => 'required|min:2|max:120',
            'cnpjcpf' => 'required|min:6|max:40',
            'history' => 'max:255',
            'ie' => 'max:60',
            'im' => 'max:60',
        ];
    }
}
