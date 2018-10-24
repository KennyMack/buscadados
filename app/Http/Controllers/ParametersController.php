<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParametersFormRequest;
use App\Parameters;
use Illuminate\Http\Request;
use Redirect;

use App\Http\Requests;

class ParametersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function parameters()
    {
        $parameters = Parameters::orderBy('id', 'desc')->first();

        return view('parameters.parameters-form',
            [
                'url' => 'admin/parameters/save',
                'parameters' => $parameters]);
    }

    public function saveParameters(ParametersFormRequest $request)
    {
        //dd($request);
        $parameters = Parameters::orderBy('id', 'desc')->first();

        $readonlyname = $request->input('readonlyname');
        $readonlydescription = $request->input('readonlydescription');

        if($readonlyname == '')
            $readonlyname = 0;

        if($readonlydescription == '')
            $readonlydescription = 0;

        if ($parameters == null) {
            $parameters = new Parameters();
            $parameters = $parameters->create([
                'readonlyname' => $readonlyname,
                'readonlydescription' => $readonlydescription,
            ]);
        }
        else {
            $parameters->readonlyname = $readonlyname;
            $parameters->readonlydescription = $readonlydescription;
            $parameters->save();

        }
        \Session::flash('message_success', 'Atualizado com sucesso');

        return Redirect::to('admin/parameters');
    }
}
