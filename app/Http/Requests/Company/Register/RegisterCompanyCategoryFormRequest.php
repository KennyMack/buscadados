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

    public function messages()
    {
        return [
            /*'categorydetail_id.min' => 'Selecione a categoria.',
            'categorydetail_id.required' => 'Selecione a categoria.',
            'categorydetail_id.integer' => 'Selecione a categoria.',*/
            'category_id.min' => 'Selecione a categoria.',
            'category_id.required' => 'Selecione a categoria.',
            'category_id.integer' => 'Selecione a categoria.'

        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (count(Request::file()) > 0) {
            foreach (Request::file() as $value) {


                $img_data = file_get_contents($value);
                $base64 = base64_encode($img_data);


                $ing = 'data:image/' . $value->getClientOriginalExtension() . ';base64,' . $base64;


                ImageCatTemp::create([
                    'session_id' => \Session::getId(),
                    'image' => $ing
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
            'category_id' => 'required|min:0|integer',
            'contract_index' => 'required|min:-1|integer',
            //'categorydetail_id' => 'required|min:0|integer',
            //'name'=> 'required|max:120',
            //'description'=> 'required|max:255',
            //'value' => 'required|numeric|min:1',
            //'value' => 'required|regex:([0-9]+[.,]?[0-9])|min:0',
            'isactive' => 'required|min:0|max:1',
        ];
    }
}
