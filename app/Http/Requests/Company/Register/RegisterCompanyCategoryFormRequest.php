<?php

namespace App\Http\Requests\Company\Register;

use App\Http\Requests\Request;
use App\ImageCatTemp;
use App\Utils\ImageContent;

class RegisterCompanyCategoryFormRequest extends Request
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
        if (count(Request::files) > 0) {
            foreach (Request::files as $key => $value) {
                ImageCatTemp::create([
                    'session_id' => \Session::getId(),
                    'image' => $value
                ]);
            }
        }


        /*if (Request::file('image') != null)
            \Session::flash('image', ImageContent::imageToBase64(Request::file('image'), Request::file('image')->getMimeType()));
        else if (Request::input('imgdata'))
            \Session::flash('image', Request::input('imgdata'));*/

        return [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'imgdata' => 'min:0',
            'categorydetail_id' => 'required|min:0|integer',
            'name'=> 'required|max:120',
            'description'=> 'required|max:255',
            //'value' => 'required|numeric|min:1',
            'value' => 'required|regex:([0-9]+[.,]?[0-9])|min:1',
            'isactive' => 'required|min:0|max:1',
        ];
    }
}
