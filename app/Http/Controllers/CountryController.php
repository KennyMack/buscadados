<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateCountryFormRequest;
use App\Http\Requests\UpdateCountryFormRequest;
use Validator;
use App\Http\Requests;
use App\Country;
use Redirect;

class CountryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $countries = Country::orderBy('name', 'asc')->paginate(10);

        return view('country.country-view', 
            [ 'countries' => $countries]);
    }

    public function countries()
    {
        return \Response::json(Country::orderBy('name', 'asc')->get());
    }

    public function newCountry()
    {
        return view('country.country-form', [
            'url' => 'admin/countries/save'
        ]);
    }

    public function changeCountry($id)
    {
        $country = Country::findOrFail($id);
        return view('country.country-form', [
            'country' => $country,
            'url' => 'admin/countries/'.$id.'/update'
        ]);
    }

    public function saveCountry(CreateCountryFormRequest $request)
    {
        $country = new Country();
        
        $country = $country->create([
            'name' => $request->input('name'),
            'initials' => $request->input('initials')
        ]);
        

        \Session::flash('message_success', 'Salvo com sucesso ');
        
        return Redirect::to('admin/countries/create');
    }

    public function updateCountry($id, UpdateCountryFormRequest $request)
    {
        $country = Country::findOrFail($id);

        $country->name = $request->input('name');
        $country->initials = $request->input('initials');
        $country->id = $id;

        $country->save();

        \Session::flash('message_success', 'Atualizado com sucesso');

        return Redirect::to('admin/countries/'.$id.'/change');
    }

    public function deleteCountry($id)
    {
        try {
            $cat = Country::findOrFail($id);

            $cat->delete();

            \Session::flash('message_warning', 'Removido com sucesso'); 
            
        } 
        catch (\Exception $e){
            $errorCode = $e->errorInfo[1];

            if($errorCode == 1451){
                \Session::flash('message_danger', 'Existem estados vinculados a este país');
            }

            /*if($errorCode == 1062){
            // houston, we have a duplicate entry problem
            }*/
        }
        
        

        return Redirect::to('admin/countries');
    }


}
