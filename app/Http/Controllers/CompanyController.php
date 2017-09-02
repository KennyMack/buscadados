<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryDetail;
use App\CompanyCategory;
use App\CompanyCatImage;
use App\Http\Requests\Company\Register\RegisterAddressFormRequest;
use App\Http\Requests\Company\Register\RegisterCategoryFormRequest;
use App\Http\Requests\Company\Register\RegisterCompanyCategoryFormRequest;
use App\Http\Requests\Company\Register\RegisterCompanyFormRequest;
use App\Http\Requests\CreateCompanyCategoryFormRequest;
use App\Models\CompanyCatImageModel;
use App\User;
use App\Utils\ImageContent;
use App\Utils\SendMail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use App\Country;
use App\State;
use App\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Utils;
use Mockery\Exception;
use Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = Company::orderBy('companyname', 'asc')->paginate(10);

        return view('company.company-view', [
            'companies' => $companies
        ]);
    }

    public function profileCompany()
    {
        $image = asset('/assets/img/company-no-image.png');

        if (\Session::has('image')) {
            $image = \Session::get('image');
        }

        $company = Auth::user()->company();

        if ($company != null && $company->hasImage())
            $image = $company->logourl;


        return view('company.register.company-form', [
            'image' => $image,
            'company' => $company,
            'tabuser' => false,
            'urlcompany' => url('companies/profile/company'),
            'urladdress' => url('companies/profile/address'),
            'urlcategory' => url('companies/profile/category'),
        ]);
    }

    public function saveProfileCompany(RegisterCompanyFormRequest $request)
    {
        $company = Auth::user()->company();
        $company->companyname = $request->input('companyname');
        $company->tradingname = $request->input('tradingname');
        $company->cnpjcpf = $request->input('cnpjcpf');
        $company->history = $request->input('history');
        $company->ie = $request->input('ie');
        $company->im = $request->input('im');
        $company->user_id = Auth::user()->id;


        if ($request->input('imgdata') != null) {

            if ($company->logopath == '') {
                $expfolder = explode('\\', $company->logopath);
                $filefolder = implode('\\', array_slice($expfolder, 0, count($expfolder) - 1));

                \File::delete($company->logopath);
                \File::deleteDirectory($filefolder);
            }

            $time = time();
            $imgname = uniqid();

            $imgpath = public_path('images/company/logo/') . $time;
            $imgurl = asset('images/company/logo/' . $time);


            if (!is_dir($imgpath)) {
                // dir doesn't exist, make it
                mkdir($imgpath, 0777, true);
            }

            $imgOrigPath = ImageContent::saveImageFromBase64($imgpath . '/', $request->input('imgdata'), $imgname);

            $extension = explode('.', $imgOrigPath)[1];

            $imgOrigUrl = $imgurl . '/' . $imgname . '.' . $extension;


            $company->logourl = $imgOrigUrl;
            $company->logopath = $imgOrigPath;
        }
        $company->save();


        return Redirect::to('/companies/profile/company');
    }

    public function profileAddress()
    {
        return view('company.register.address-form', [
            'countries' => $this->getContries(),
            'states' => $this->getStates(1),
            'cities' => [],
            'company' => Auth::user()->company(),
            'tabuser' => false,
            'urlcompany' => url('companies/profile/company'),
            'urladdress' => url('companies/profile/address'),
            'urlcategory' => url('companies/profile/category'),
        ]);
    }

    public function saveProfileAddress(RegisterAddressFormRequest $request)
    {
        $company = Auth::user()->company();

        $company->city_id = $request->input('city_id');
        $company->address = $request->input('address');
        $company->number = $request->input('number');
        $company->postalnumber = $request->input('postalnumber');
        $company->district = $request->input('district');
        $company->phone = $request->input('phone');

        $company->save();


        return Redirect::to('/companies/profile/address');
    }

    public function profileCategory()
    {
        $image = asset('/assets/img/category-no-image.png');


        $company = Auth::user()->company();
        return view('company.register.category-form', [
            'categories' => $this->getCategoriesDetails(),
            'company' => $company,
            'url' => url('companies/profile/category/add'),
            'images' => [],
            'tabuser' => false,
            'i' => 1,
            'imgtemp' => CompanyCatImageModel::getTempImages($company->id, 0),
            'urlcompany' => url('companies/profile/company'),
            'urladdress' => url('companies/profile/address'),
            'urlcategory' => url('companies/profile/category'),
        ]);
    }

    public function changeProfileCategory($idCompanyCategory, RegisterCompanyCategoryFormRequest $request)
    {
        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

        $categoryDetail = CategoryDetail::findOrFail($request->input('categorydetail_id'));

        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
        ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

        if ($validator->fails()) {
            return redirect('companies/profile/category')
                ->withErrors($validator)
                ->withInput();
        }
        $company = Auth::user()->company();



        $companyCategory->categorydetail_id = $request->categorydetail_id;
        $companyCategory->name = $request->name;
        $companyCategory->description = $request->description;
        $companyCategory->value = $request->value;
        $companyCategory->isactive = $request->isactive;

        $companyCategory->save();
        if (count($request->input('imgdata') ) >0) {
            CompanyCatImageModel::saveImagesCategory(
                $request->input('imgdata'),
                $company->id,
                $idCompanyCategory
            );
        }

        $deletedImages = explode('-', $request->input('deletedImage'));

        CompanyCatImageModel::deleteImagesCategory(
            $deletedImages,
            $company->id,
            $idCompanyCategory
        );

        CompanyCatImageModel::clearTempImages();


        $request->session()->forget('image');
        return Redirect::to('/companies/profile/category');
    }

    public function editProfileCategory($idCompanyCategory)
    {
        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

        $image = $companyCategory->getImage();

        if (!$companyCategory->hasImage())
            $image = asset('/assets/img/category-no-image.png');



        $company = Auth::user()->company();

        return view('company.register.category-form', [
            'categories' => $this->getCategoriesDetails(),
            'company' => $company,
            'image' => $image,
            'images'=> $this->getCompanyCategoryImages($idCompanyCategory),
            'companyCategory' => $companyCategory,
            'url' => url('companies/profile/category/'.$idCompanyCategory.'/update'),
            'tabuser' => false,
            'i' => 1,
            'imgtemp' => CompanyCatImageModel::getTempImages($company->id, $idCompanyCategory),
            'urlcompany' => url('companies/profile/company'),
            'urladdress' => url('companies/profile/address'),
            'urlcategory' => url('companies/profile/category'),
        ]);
    }

    public function messages($min, $max)
    {
        return [
            'value.required' => 'O campo valor é obrigatório.',
            'value.numeric' => 'O campo valor deve ser um número.',
            'value.min' => 'O campo valor deve estar entre '.$min.' e '.$max.'.',
            'value.max' => 'O campo valor deve estar entre '.$min.' e '.$max.'.',
        ];
    }

    public function addProfileCategory(RegisterCompanyCategoryFormRequest $request)
    {

        $categoryDetail = CategoryDetail::findOrFail($request->input('categorydetail_id'));
        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
        ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

        if ($validator->fails()) {
            return redirect('companies/profile/category')
                ->withErrors($validator)
                ->withInput();
        }

        $companyCategory = CompanyCategory::create([
            'company_id' => Auth::user()->company()->id,
            'categorydetail_id' => $request->input('categorydetail_id'),
            'imagepath' => '',
            'imageurl' => '',
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'value' => $request->input('value'),
            'isactive'=> $request->input('isactive'),
        ]);

        if ($request->input('imgdata') != null) {

            $time = time();
            $imgname = uniqid();

            $imgpath = public_path('images/company/category/') . $time;
            $imgurl = asset('images/company/category/' . $time);


            if (!is_dir($imgpath)) {
                // dir doesn't exist, make it
                mkdir($imgpath, 0777, true);
            }

            $imgOrigPath = ImageContent::saveImageFromBase64($imgpath . '/', $request->input('imgdata'), $imgname);

            $extension = explode('.', $imgOrigPath)[1];

            $imgOrigUrl = $imgurl . '/' . $imgname . '.' . $extension;

            $companyCategory->imageurl = $imgOrigUrl;
            $companyCategory->imagepath = $imgOrigPath;
            $companyCategory->save();
        }

        $request->session()->forget('image');
        return Redirect::to('/companies/profile/category');
    }

    public function deleteProfileCategory($idCompanyCategory)
    {
        try {

            /* checks whether company has this category detail */

            $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

            $companyCategory->delete();

            \Session::flash('message_detail_warning', 'Removido com sucesso');

        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                \Session::flash('message_danger', 'Existem empresas vinculadas a esta categoria.');
            }
        }
        return Redirect::to('/companies/profile/category');
    }

    public function saveProfileCategory()
    {
        $company = Auth::user()->company();
        $user = Auth::user();

        $company->status = 3;
        $company->save();

        try{

            $send_email = new Utils\SendMail();

            $send_email->SendChanged($user->email, $company);
        }
        catch (\Exception $e)
        {

        }

        \Session::flash('message_success', 'Seu cadastro foi alterado, basta aguardar a ativação dos seus dados.');


        return Redirect::to('/home');
    }

    private function getContries()
    {
        return Country::all();
    }

    private function getStates($country_id)
    {
        return State::where('country_id', $country_id)->orderBy('name')->get();
    }

    private function getCities($state_id)
    {
        return City::where('state_id', $state_id)->orderBy('name')->get();
    }

    private function getCategories()
    {
        return Category::orderBy('name')->get();
    }

    private function getCompanyCategoryImages($idCompanyCat)
    {
        return CompanyCatImage::where('company_category_id', $idCompanyCat)->get();
    }

    private function getCategoriesDetails()
    {
        return CategoryDetail::join('category as cat', 'cat.id', '=', 'category_details.category_id')
            ->where('category_details.isactive', 1)
            ->select('category_details.id',
                'category_details.name',
                'cat.name as categoryname',
                'category_details.minvalue',
                'category_details.maxvalue')
            ->orderBy('cat.name')
            ->orderBy('category_details.name', 'desc')
            ->get();
    }

    public function details($id)
    {
        return view('company.company-detail', [
           'company' => Company::findOrFail($id)
        ]);
    }

    public function enable($id)
    {
        $company = Company::findOrFail($id);

        $company->status = 1;

        $company->save();

        $user = User::find($company->user_id);

        $user->isactive =1;
        $user->save();

        try {
            $send_email = new SendMail();

            $send_email->SendEnabled($company->user->email, $company);
        }
        catch (\Exception $e)
        {

        }

        return Redirect::to('admin/companies');
    }

    public function disable($id)
    {
        $company = Company::findOrFail($id);

        $company->status = 2;

        $company->save();

        try {
            $send_email = new SendMail();

            $send_email->SendDisabled($company->user->email, $company);
        }
        catch (\Exception $e) {

        }

        return Redirect::to('admin/companies');
    }

    public function companiesDisabled()
    {
        $companies = Company::where('status', '=', 0)->orderBy('companyname', 'asc')->paginate(10);

        return view('company.company-view', [
            'companies' => $companies
        ]);
    }


    /**
     * Register Company
     */
    public function registerCompany()
    {
        $image = asset('/assets/img/company-no-image.png');

        if (\Session::has('image')) {
            $image = \Session::get('image');
        }

        $company = Auth::user()->company();

        if ($company != null && $company->hasImage())
            $image = $company->logourl;


        return view('company.register.company-form', [
            'image' => $image,
            'company' => $company,
            'tabuser' => true,
            'urlcompany' => '#',
            'urladdress' => '#',
            'urlcategory' => '#',
        ]);
    }

    public function saveRegisterCompany(RegisterCompanyFormRequest $request)
    {
        $company = Auth::user()->company();
        $new = true;
        if ($company == null) {

            $company = Company::create([
                'companyname' => $request->input('companyname'),
                'tradingname' => $request->input('tradingname'),
                'status' => 0,
                'cnpjcpf' => $request->input('cnpjcpf'),
                'history' => $request->input('history'),
                'ie' => $request->input('ie'),
                'im' => $request->input('im'),
                'logopath' => '',
                'user_id' => Auth::user()->id,
            ]);
        }
        else {
            $new = false;
            $company->companyname = $request->input('companyname');
            $company->tradingname = $request->input('tradingname');
            $company->cnpjcpf = $request->input('cnpjcpf');
            $company->history = $request->input('history');
            $company->ie = $request->input('ie');
            $company->im = $request->input('im');
            $company->user_id = Auth::user()->id;

            $company->save();
        }


        if ($request->input('imgdata') != null) {
            $imgOrigUrl = '';
            $imgOrigPath = '';

            if ($company->logopath == '') {
                $expfolder = explode('\\', $company->logopath);
                $filefolder = implode('\\', array_slice($expfolder , 0, count($expfolder) -1));

                \File::delete($company->logopath);
                \File::deleteDirectory($filefolder);
            }

            $time = time();
            $imgname = uniqid();

            $imgpath = public_path('images/company/logo/') . $time;
            $imgurl = asset('images/company/logo/' . $time);


            if (!is_dir($imgpath)) {
                // dir doesn't exist, make it
                mkdir($imgpath, 0777, true);
            }

            $imgOrigPath = ImageContent::saveImageFromBase64($imgpath . '/', $request->input('imgdata'), $imgname);

            $extension = explode('.', $imgOrigPath)[1];

            $imgOrigUrl = $imgurl . '/' . $imgname . '.' . $extension;


            $company->logourl = $imgOrigUrl;
            $company->logopath = $imgOrigPath;
            $company->save();
        }


        return Redirect::to('/register/address');

    }

    /**
     * Register Address
     */
    public function registerAddress()
    {
        return view('company.register.address-form', [
            'countries' => $this->getContries(),
            'states' => $this->getStates(1),
            'cities' => [],
            'company' => Auth::user()->company(),
            'tabuser' => true,
            'urlcompany' => '#',
            'urladdress' => '#',
            'urlcategory' => '#',
        ]);
    }

    public function saveRegisterAddress(RegisterAddressFormRequest $request)
    {
        $company = Auth::user()->company();

        $company->city_id = $request->input('city_id');
        $company->address = $request->input('address');
        $company->number = $request->input('number');
        $company->postalnumber = $request->input('postalnumber');
        $company->district = $request->input('district');
        $company->phone = $request->input('phone');

        $company->save();


        return Redirect::to('/register/category');
    }

    /**
     * Register Category
     */
    public function registerCategory()
    {
        $image = asset('/assets/img/category-no-image.png');

        if (\Session::has('image')) {
            $image = \Session::get('image');
        }

        $company = Auth::user()->company();
        return view('company.register.category-form', [
            'categories' => $this->getCategoriesDetails(),
            'company' => $company,
            'image' => $image,
            'url' => url('register/category/add'),
            'tabuser' => true,
            'images' => [],
            'urlcompany' => '#',
            'urladdress' => '#',
            'urlcategory' => '#',
        ]);
    }

    public function editRegisterCategory($idCompanyCategory)
    {
        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

        $image = $companyCategory->getImage();

        if (!$companyCategory->hasImage())
            $image = asset('/assets/img/category-no-image.png');

        $company = Auth::user()->company();

        return view('company.register.category-form', [
            'categories' => $this->getCategoriesDetails(),
            'company' => $company,
            'image' => $image,
            'companyCategory' => $companyCategory,
            'images'=> $this->getCompanyCategoryImages($idCompanyCategory),
            'url' => url('register/category/'.$idCompanyCategory.'/update'),
            'tabuser' => true,
            'urlcompany' => '#',
            'urladdress' => '#',
            'urlcategory' => '#',
        ]);
    }

    public function changeRegisterCategory($idCompanyCategory, RegisterCompanyCategoryFormRequest $request)
    {
        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

        $categoryDetail = CategoryDetail::findOrFail($request->input('categorydetail_id'));

        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
        ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

        if ($validator->fails()) {
            return redirect('companies/profile/category')
                ->withErrors($validator)
                ->withInput();
        }

        $companyCategory->categorydetail_id = $request->categorydetail_id;
        $companyCategory->name = $request->name;
        $companyCategory->description = $request->description;
        $companyCategory->value = $request->value;
        $companyCategory->isactive = $request->isactive;


        if ($request->input('imgdata') != null) {


            if ($companyCategory->imagepath != '') {
                $expfolder = explode('\\', $companyCategory->imagepath);
                $filefolder = implode('\\', array_slice($expfolder , 0, count($expfolder) -1));

                \File::delete($companyCategory->imagepath);
                \File::deleteDirectory($filefolder);

            }

            $time = time();
            $imgname = uniqid();

            $imgpath = public_path('images/company/category/') . $time;
            $imgurl = asset('images/company/category/' . $time);


            if (!is_dir($imgpath)) {
                mkdir($imgpath, 0777, true);
            }

            $imgOrigPath = ImageContent::saveImageFromBase64($imgpath . '/', $request->input('imgdata'), $imgname);

            $extension = explode('.', $imgOrigPath)[1];

            $imgOrigUrl = $imgurl . '/' . $imgname . '.' . $extension;



            $companyCategory->imageurl = $imgOrigUrl;
            $companyCategory->imagepath = $imgOrigPath;
        }

        $companyCategory->save();


        $request->session()->forget('image');
        return Redirect::to('/register/category');
    }

    public function addRegisterCategory(RegisterCompanyCategoryFormRequest $request)
    {
        $categoryDetail = CategoryDetail::findOrFail($request->input('categorydetail_id'));

        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
        ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

        if ($validator->fails()) {
            return redirect('companies/profile/category')
                ->withErrors($validator)
                ->withInput();
        }

        $companyCategory = CompanyCategory::create([
            'company_id' => Auth::user()->company()->id,
            'categorydetail_id' => $request->input('categorydetail_id'),
            'imagepath' => '',
            'imageurl' => '',
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'value' => $request->input('value'),
            'isactive'=> $request->input('isactive'),
        ]);

        if ($request->input('imgdata') != null) {

            $time = time();
            $imgname = uniqid();

            $imgpath = public_path('images/company/category/') . $time;
            $imgurl = asset('images/company/category/' . $time);


            if (!is_dir($imgpath)) {
                // dir doesn't exist, make it
                mkdir($imgpath, 0777, true);
            }

            $imgOrigPath = ImageContent::saveImageFromBase64($imgpath . '/', $request->input('imgdata'), $imgname);

            $extension = explode('.', $imgOrigPath)[1];

            $imgOrigUrl = $imgurl . '/' . $imgname . '.' . $extension;

            $companyCategory->imageurl = $imgOrigUrl;
            $companyCategory->imagepath = $imgOrigPath;
            $companyCategory->save();
        }

        $request->session()->forget('image');
        return Redirect::to('/register/category');
    }

    public function deleteRegisterCategory($idCompanyCategory)
    {
        try {

            /* checks whether company has this category detail */

            $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

            $companyCategory->delete();

            \Session::flash('message_detail_warning', 'Removido com sucesso');

        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                \Session::flash('message_danger', 'Existem empresas vinculadas a esta categoria.');
            }

            /*if($errorCode == 1062){
            // houston, we have a duplicate entry problem
            }*/
        }
        return Redirect::to('/register/category');
    }

    public function saveRegisterCategory()
    {
        $company = Auth::user()->company();
        $user = Auth::user();

        $user->firstlogin = 0;
        $user->save();

        try {
            $send_email = new Utils\SendMail();

            $send_email->SendRegister($user->email, $company);
        }
        catch (\Exception $e)
        {

        }

        \Session::flash('message_success', 'Seu cadastro foi concluído, basta aguardar a ativação dos seus dados.');


        return Redirect::to('/home');
    }



}
