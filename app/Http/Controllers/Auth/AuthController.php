<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\City;
use App\Country;
use App\State;
use App\User;
use App\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Utils;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    private function getContries()
    {
        return Country::all();
    }

    private function getStates($country_id)
    {
        return State::where('country_id', $country_id)->get();
    }

    private function getCities($state_id)
    {
        return City::where('state_id', $state_id)->get();
    }

    private function getCategories()
    {
        return Category::all();
    }


    public function showRegistrationForm()
    {
        //$image = asset('/assets/img/no-image.png');



        //if (\Session::has('image'))
       // {
        //    $image = \Session::get('image');
        //}

        //var_dump(Request);
        return view('auth.register', [
            //'categories' => $this->getCategories(),
            //'countries' => $this->getContries(),
            //'states' => $this->getStates(1),
            //'cities' => [],//$this->getCities(1),
            //'image' => $image
        ]);
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/register/company';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /*if (isset($data['image']))
            dd($data['image']);*/

        //\Session::flash('image', 'data:'.$data['image']->getMimeType().';base64, ' .  base64_encode(file_get_contents($data['image'])));
        //if (isset($data['image']))
        //    \Session::flash('image', Utils\ImageContent::imageToBase64($data['image'], $data['image']->getMimeType()));

        return Validator::make($data, [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'type' => 'max:255',
            'isactive' => 'max:255',
            'firstlogin' => 'max:255',
            'password' => 'required|min:6|confirmed',
            /*'companyname' => 'required|min:2|max:120',
            'tradingname' => 'required|min:2|max:120',
            'city_id' => 'required|min:0|integer',
            'category_id' => 'required|min:0|integer',
            'address' => 'required|min:2|max:255',
            'number' => 'required|max:15',
            'postalnumber' => 'required|min:2|max:15',
            'district' => 'required|min:2|max:60',
            'cnpjcpf' => 'required|min:6|max:40',
            'history' => 'max:255',
            'phone' => 'max:60',
            'ie' => 'max:60',
            'im' => 'max:60',*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       // DB::beginTransaction();
        $user = new User();

        $user = $user->create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'type' => 0,
            'isactive' => 0,
            'firstlogin' => 1,
            'password' => bcrypt($data['password']),
        ]);

        //public_path('\images\a\\') .

       /*
        * funcionando topper
        *
        *  $imgpath = public_path('\images\company\logo\\') . time();

        $imgname = uniqid();

        if (!is_dir($imgpath)) {
            // dir doesn't exist, make it
            mkdir($imgpath,0777,true);
        }


        $imgOrigPath = Utils\ImageContent::saveImageFromBase64($imgpath .'\\', $request['imgdata'], $imgname);
*/


        /*try
        {
            $user = $user->create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'type' => 0,
                'isactive' => 0,
                'firstlogin' => 1,
                'password' => bcrypt($data['password']),
            ]);

            $company = Company::create([
                'companyname' => $data['companyname'],
                'tradingname' => $data['tradingname'],
                'status' => 0,
                'city_id' => $data['city_id'],
                'category_id' => $data['category_id'],
                'address' => $data['address'],
                'number' => $data['number'],
                'postalnumber' => $data['postalnumber'],
                'district' => $data['district'],
                'cnpjcpf' => $data['cnpjcpf'],
                'history' => $data['history'],
                'phone' => $data['phone'],
                'ie' => $data['ie'],
                'im' => $data['im'],
                'user_id' => $user->id,
            ]);

            $send_email = new Utils\SendMail();

            $send_email->SendRegister($user->email, $company);

            \Session::flash('message_success', 'Seu cadastro foi concluído, basta aguardar a ativação dos seus dados.');

            DB::commit();
        }
        catch (\Exception $e)
        {
           DB::rollback();
        }*/



        return $user;
    }
}
