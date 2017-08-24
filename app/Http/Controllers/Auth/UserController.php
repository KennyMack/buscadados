<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Http\Requests\CreateUserFormRequest;
use App\Http\Requests\UpdateUserFormRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('type', 1)-> orderBy('name', 'asc')->paginate(10);

        return view('auth.users.users-view',
            [ 'users' => $users]);
    }

    public function newUser()
    {
        return view('auth.users.users-form', [
            'url' => 'admin/users/save'
        ]);
    }

    public function saveUser(CreateUserFormRequest $request)
    {
        $user = new User();

        $active = $request->input('isactive');

        if($active == '')
            $active = 0;

        $user = $user->create([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'type' => 1,
            'password' => bcrypt($request->input('password')),
            'firstlogin' => 1,
            'isactive' => $active
        ]);


        \Session::flash('message_success', 'Salvo com sucesso ');

        return Redirect::to('admin/users/create');
    }

    public function changeUser($id)
    {
        $user = User::findOrFail($id);
        return view('auth.users.users-form', [
            'url' => 'admin/users/'.$id.'/update',
            'user' => $user
        ]);
    }

    public function updateUser($id, UpdateUserFormRequest $request)
    {
        $user = User::findOrFail($id);

        $active = $request->input('isactive');

        if($active == '')
            $active = 0;

        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        //$user->email = $request->input('email');
        if ($request->input('password') != '')
            $user->password = bcrypt($request->input('password'));
        $user->type = 1;
        $user->isactive = $active;
        $user->firstlogin = 1;

        $user->save();

        \Session::flash('message_success', 'Atualizado com sucesso');

        return Redirect::to('admin/users/'.$id.'/change');
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            \Session::flash('message_warning', 'Removido com sucesso');
        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                \Session::flash('message_danger', 'Existem empresas vinculada a esse usuário.');
            }

        }

        return Redirect::to('admin/users');
    }
}

