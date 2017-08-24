<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Requests\CreateStateFormRequest;
use App\Http\Requests\UpdateStateFormRequest;
use App\State;
use App\Country;
use Redirect;

class StateController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $states = State::orderBy('name', 'asc')->paginate(10);

        return view('state.state-view',
            [ 'states' => $states]);
    }

    public function states($country_id)
    {
        return \Response::json(State::where('country_id', $country_id)->orderBy('name', 'asc')->get());
    }

    private function getCountries() 
    {
        return Country::all();
    }

    public function newState()
    {

        return view('state.state-form', [
            'url' => 'admin/states/save',
            'countries' => $this->getCountries()
        ]);
    }

    public function changeState($id)
    {
        $state = State::findOrFail($id);
        return view('state.state-form', [
            'state' => $state,
            'url' => 'admin/states/'.$id.'/update',
            'countries' => $this->getCountries()
        ]);
    }

    public function saveState(CreateStateFormRequest $request)
    {
        $state = new State();

        
        $state = $state->create([
            'name' => $request->input('name'),
            'initials' => $request->input('initials'),
            'country_id' => $request->input('country_id')
        ]);
        

        \Session::flash('message_success', 'Salvo com sucesso ');
        
        return Redirect::to('admin/states/create');
    }

    public function updateState($id, UpdateStateFormRequest $request)
    {
        $state = State::findOrFail($id);

        $state->name = $request->input('name');
        $state->initials = $request->input('initials');
        $state->country_id = $request->input('country_id');
        $state->id = $id;

        $state->save();

        \Session::flash('message_success', 'Atualizado com sucesso');

        return Redirect::to('admin/states/'.$id.'/change');
    }

    public function deleteState($id)
    {
        try
        {
            $state = State::findOrFail($id);

            $state->delete();

            \Session::flash('message_warning', 'Removido com sucesso');
        }
        catch (\Exception $e){
            $errorCode = $e->errorInfo[1];

            if($errorCode == 1451){
                \Session::flash('message_danger', 'Existem cidades vinculadas a este estado');
            }

            /*if($errorCode == 1062){
            // houston, we have a duplicate entry problem
            }*/
        }
        return Redirect::to('admin/states');
    }


}
