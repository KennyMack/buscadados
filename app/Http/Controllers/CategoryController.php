<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Requests\UpdateCategoriesFormRequest;
use App\Http\Requests\CreateCategoriesFormRequest;
use App\Category;
use Redirect;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $categories = Category::orderBy('name', 'asc')->paginate(10);

        return view('category.categoryview', 
            [ 'categories' => $categories]);
    }

    public function newCategory()
    {
        return view('category.categoryform', [
            'url' => 'admin/categories/save'
        ]);
    }

    public function changeCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('category.categoryform', [
            'category' => $category,
            'url' => 'admin/categories/'.$id.'/update'
        ]);
    }

    public function saveCategory(CreateCategoriesFormRequest $request)
    {
        $cat = new Category();

        $active = $request->input('isactive');
        //$readonlyname = $request->input('readonlyname');
        //$readonlydescription = $request->input('readonlydescription');

        if($active == '')
            $active = 0;

        //if($readonlyname == '')
        //    $readonlyname = 0;
        //
        //if($readonlydescription == '')
        //    $readonlydescription = 0;

        $cat = $cat->create([
            'name' => $request->input('name'),
            'orderby' => $request->input('orderby'),
            'type' => $request->input('type'),
            'icon' => $request->input('icon'),
            //'readonlyname' => $readonlyname,
            //'readonlydescription' => $readonlydescription,
            'isactive' => $active
        ]);


        

        \Session::flash('message_success', 'Salvo com sucesso ');
        
        return Redirect::to('admin/categories/create');
    }

    public function updateCategory($id, UpdateCategoriesFormRequest $request)
    {
        $cat = Category::findOrFail($id);

        $active = $request->input('isactive');
        // $readonlyname = $request->input('readonlyname');
        // $readonlydescription = $request->input('readonlydescription');

        if($active == '')
            $active = 0;

        //if($readonlyname == '')
        //    $readonlyname = 0;
        //
        //if($readonlydescription == '')
        //    $readonlydescription = 0;

        $cat->name = $request->input('name');
        $cat->orderby = $request->input('orderby');
        $cat->type = $request->input('type');
        $cat->icon = $request->input('icon');
        //$cat->readonlyname = $readonlyname;
        //$cat->readonlydescription = $readonlydescription;
        $cat->isactive = $active;
        $cat->id = $id;

        $cat->save();

        \Session::flash('message_success', 'Atualizado com sucesso');

        return Redirect::to('admin/categories/'.$id.'/change');
    }

    public function deleteCategory($id)
    {
        try {
            $cat = Category::findOrFail($id);

            $cat->delete();

            \Session::flash('message_warning', 'Removido com sucesso');
        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                \Session::flash('message_danger', 'Existem detalhes vinculados a esta categoria.');
            }

        }

        return Redirect::to('admin/categories');
    }
}
