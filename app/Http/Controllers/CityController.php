<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Requests\CreateCityFormRequest;
use App\Http\Requests\UpdateCityFormRequest;
use App\City;
use App\State;
use Redirect;

class CityController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $cities = City::orderBy('name', 'asc')->paginate(10);

        return view('city.city-view', 
            [ 'cities' => $cities]);
    }

    public function cities($country_id, $state_id)
    {
        return \Response::json(City::where('state_id', $state_id)->orderBy('name', 'asc')->get());
    }

    private function getStates() 
    {
        return State::all();
    }

    public function newCity()
    {

        return view('city.city-form', [
            'url' => 'admin/cities/save',
            'states' => $this->getStates()
        ]);
    }

    public function changeCity($id)
    {
        $city = City::findOrFail($id);
        return view('city.city-form', [
            'city' => $city,
            'url' => 'admin/cities/'.$id.'/update',
            'states' => $this->getStates()
        ]);
    }

    public function saveCity(CreateCityFormRequest $request)
    {
        $city = new City();
        
        $city = $city->create([
            'name' => $request->input('name'),
            'state_id' => $request->input('state_id')
        ]);
        

        \Session::flash('message_success', 'Salvo com sucesso ');
        
        return Redirect::to('admin/cities/create');
    }

    public function updateCity($id, UpdateCityFormRequest $request)
    {
        $city = City::findOrFail($id);

        $city->name = $request->input('name');
        $city->state_id = $request->input('state_id');
        $city->id = $id;

        $city->save();

        \Session::flash('message_success', 'Atualizado com sucesso');

        return Redirect::to('admin/cities/'.$id.'/change');
    }

    public function deleteCity($id)
    {
        try
        {
            $city = City::findOrFail($id);

            $city->delete();

            \Session::flash('message_warning', 'Removido com sucesso');
        }
        catch (\Exception $e){
            $errorCode = $e->errorInfo[1];

            if($errorCode == 1451){
                \Session::flash('message_danger', 'Existem empresas vinculadas a esta cidade');
            }

            /*if($errorCode == 1062){
            // houston, we have a duplicate entry problem
            }*/
        }

        return Redirect::to('admin/cities');
    }
}
