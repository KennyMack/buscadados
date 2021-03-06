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
use App\Parameters;
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
        $company->cellphone = $request->input('cellphone');
        $company->site = $request->input('site');

        $company->save();


        return Redirect::to('/companies/profile/address');
    }

    public function profileCategory()
    {
        $param = $this->getParameters();

        $readonlydescription = 0;
        $readonlyname = 0;

        if ($param != null){
            $readonlydescription = $param->readonlydescription;
            $readonlyname = $param->readonlyname;
        }

        $company = Auth::user()->company();
        return view('company.register.category-form', [
            'categories' => $this->getCategories(),
            'categoriesdetail' => [],//$this->getCategoriesDetails(),
            'company' => $company,
            'url' => url('companies/profile/category/add'),
            'images' => [],
            'tabuser' => false,
            'imgtemp' => CompanyCatImageModel::getTempImages(),
            'urlcompany' => url('companies/profile/company'),
            'urladdress' => url('companies/profile/address'),
            'urlcategory' => url('companies/profile/category'),
            'readonlydescription' => $readonlydescription,
            'readonlyname' => $readonlyname,
        ]);
    }

    public function addProfileCategory(RegisterCompanyCategoryFormRequest $request)
    {
        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $category = Category::findOrFail($request->input('category_id'));
        $categoryDetail = CategoryDetail::find($request->input('categorydetail_id'));

        $company_id  = Auth::user()->company()->id;
        $category_id  = $request->input('category_id');
        $categorydetail_id  = $request->input('categorydetail_id') === '-1' ? null :$request->input('categorydetail_id');

        $name = $request->input('name');
        $description = $request->input('description');

        if ($category->type == 1) {
            $name = $category->name;
            $description = $category->name;
        }
        else {
            $param = $this->getParameters();

            $readonlydescription = 0;
            $readonlyname = 0;

            if ($param != null){
                $readonlydescription = $param->readonlydescription;
                $readonlyname = $param->readonlyname;
            }

            if ($readonlydescription == 1) {
                $description = $categoryDetail->description;
            }

            if ($readonlyname == 1) {
                $name = $categoryDetail->name;
            }
        }

        $value  = $request->input('value');
        $isactive = $request->input('isactive');
        $contract_index = $request->input('contract_index');


        if ($categoryDetail != null) {

            $validator = Validator::make($request->all(), [
                'value' => 'required|numeric|min:' . floatval($categoryDetail->minvalue) . '|max:' . floatval($categoryDetail->maxvalue),
            ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

            if ($validator->fails()) {
                return redirect('companies/profile/category')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        else {
            // 0 - category detail 1 - category contract
            if ($category->type == 0) {

                $validator = Validator::make($request->all(), [
                    'categorydetail_id' => 'required|min:0|integer',
                    'name' => 'required|max:120',
                    'description' => 'required|max:255',
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('companies/profile/category')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            else {
                $validator = Validator::make($request->all(), [
                    'contract_index' => 'required|min:0|integer'
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('companies/profile/category')
                        ->withErrors($validator)
                        ->withInput();
                }

                $value = 0;
                // $name = 'Contrato';
                // $description = '';
            }
        }

        $company = Auth::user()->company();

        $companyCategory = CompanyCategory::create([
            'company_id' => $company_id,
            'category_id' => $category_id,
            'categorydetail_id' => $categorydetail_id,
            'imagepath' => '',
            'imageurl' => '',
            'name' => $name,
            'description' => $description,
            'value' => $value,
            'contract_index' => $contract_index,
            'isactive'=> $isactive,
        ]);

        if (count($request->input('imgdata') ) > 0) {
            CompanyCatImageModel::saveImagesCategory(
                $request->input('imgdata'),
                $company->id,
                $companyCategory->id
            );
        }

        CompanyCatImageModel::clearTempImages();

        return Redirect::to('/companies/profile/category');
    }

    public function changeProfileCategory($idCompanyCategory, RegisterCompanyCategoryFormRequest $request)
    {
        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

        $category = Category::findOrFail($request->input('category_id'));
        $categoryDetail = CategoryDetail::find($request->input('categorydetail_id'));

        $category_id  = $request->input('category_id');
        $categorydetail_id  = $request->input('categorydetail_id') === '-1' ? null :$request->input('categorydetail_id');

        $name = $request->input('name');
        $description = $request->input('description');

        if ($category->type == 1) {
            $name = $category->name;
            $description = $category->name;
        }
        else {
            $param = $this->getParameters();

            $readonlydescription = 0;
            $readonlyname = 0;

            if ($param != null){
                $readonlydescription = $param->readonlydescription;
                $readonlyname = $param->readonlyname;
            }

            if ($readonlydescription == 1) {
                $description = $categoryDetail->description;
            }

            if ($readonlyname == 1) {
                $name = $categoryDetail->name;
            }
        }

        $value  = $request->input('value');
        $isactive = $request->input('isactive');
        $contract_index = $request->input('contract_index');

        if ($categoryDetail != null) {

            $validator = Validator::make($request->all(), [
                'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
            ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

            if ($validator->fails()) {
                return redirect('companies/profile/category/'.$idCompanyCategory.'/change')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        else {
            // 0 - category detail 1 - category contract
            if ($category->type == 0) {

                $validator = Validator::make($request->all(), [
                    'categorydetail_id' => 'required|min:0|integer',
                    'name' => 'required|max:120',
                    'description' => 'required|max:255',
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('companies/profile/category/'.$idCompanyCategory.'/change')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            else {
                $validator = Validator::make($request->all(), [
                    'contract_index' => 'required|min:0|integer'
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('companies/profile/category/'.$idCompanyCategory.'/change')
                        ->withErrors($validator)
                        ->withInput();
                }

                $value = 0;
                // $name = 'Contrato';
                // $description = '';
            }
        }

        $company = Auth::user()->company();

        $companyCategory->category_id = $category_id;
        $companyCategory->categorydetail_id = $categorydetail_id;
        $companyCategory->name = $name;
        $companyCategory->description = $description;
        $companyCategory->value = $value;
        $companyCategory->isactive = $isactive;
        $companyCategory->contract_index = $contract_index;

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


        return Redirect::to('/companies/profile/category');
    }

    public function editProfileCategory($idCompanyCategory)
    {
        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);
        $param = $this->getParameters();

        $readonlydescription = 0;
        $readonlyname = 0;

        if ($param != null){
            $readonlydescription = $param->readonlydescription;
            $readonlyname = $param->readonlyname;
        }

        $company = Auth::user()->company();

        return view('company.register.category-form', [
            'categories' => $this->getCategories(),
            'categoriesdetail' => [],//$this->getCategoriesDetails($companyCategory->id),
            'company' => $company,
            'images'=> $this->getCompanyCategoryImages($idCompanyCategory),
            'companyCategory' => $companyCategory,
            'url' => url('companies/profile/category/'.$idCompanyCategory.'/update'),
            'tabuser' => false,
            'imgtemp' => CompanyCatImageModel::getTempImages(),
            'urlcompany' => url('companies/profile/company'),
            'urladdress' => url('companies/profile/address'),
            'urlcategory' => url('companies/profile/category'),
            'readonlydescription' => $readonlydescription,
            'readonlyname' => $readonlyname,
        ]);
    }

    public function messages($min, $max)
    {
        return [
            'value.required' => 'O campo valor é obrigatório.',
            'value.numeric' => 'O campo valor deve ser um número.',
            'value.min' => 'O campo valor deve estar entre '.$min.' e '.$max.'.',
            'value.max' => 'O campo valor deve estar entre '.$min.' e '.$max.'.',

            'categorydetail_id.required' => 'Selecione a sub-categoria.',
            'categorydetail_id.integer' => 'Selecione a sub-categoria.',
            'categorydetail_id.min' => 'Selecione a sub-categoria.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome deve ter no max. 255 caracteres.',

            'description.required' => 'O campo descrição é obrigatório.',
            'description.max' => 'O campo descrição deve ter no max. 255 caracteres.',

            'contract_index.required' => 'Selecione o número de contratos.',
            'contract_index.integer' => 'Selecione o número de contratos.',
            'contract_index.min' => 'Selecione o número de contratos.',

        ];
    }

    public function deleteProfileCategory($idCompanyCategory)
    {
        try {

            $companyCatImage = CompanyCatImage::where('company_category_id', $idCompanyCategory)->get();
            foreach ($companyCatImage as $image)
            {
                $image->delete();
            }

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

    public function getParameters()
    {
        $param = Parameters::all();

        if (count($param) > 0)
            return $param[0];

        return null;
    }

    private function getContries()
    {
        return Country::all();
    }

    private function getStates($country_id)
    {
        return State::where('country_id', $country_id)->orderBy('name')->get();
    }

    private function getCategories()
    {
        return Category::where('isactive', 1)->orderBy('orderby')->get();
    }

    private function getCompanyCategoryImages($idCompanyCat)
    {
        return CompanyCatImage::where('company_category_id', $idCompanyCat)->get();
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
        $company->cellphone = $request->input('cellphone');
        $company->site = $request->input('site');

        $company->save();


        return Redirect::to('/register/category');
    }

    /**
     * Register Category
     */
    public function registerCategory()
    {

        $company = Auth::user()->company();
        $param = $this->getParameters();

        $readonlydescription = 0;
        $readonlyname = 0;

        if ($param != null){
            $readonlydescription = $param->readonlydescription;
            $readonlyname = $param->readonlyname;
        }

        return view('company.register.category-form', [
            'categories' => $this->getCategories(),
            'categoriesdetail' => [],//$this->getCategoriesDetails(),
            'company' => $company,
            'url' => url('register/category/add'),
            'tabuser' => true,
            'images' => [],
            'imgtemp' => CompanyCatImageModel::getTempImages(),
            'urlcompany' => '#',
            'urladdress' => '#',
            'urlcategory' => '#',
            'readonlydescription' => $readonlydescription,
            'readonlyname' => $readonlyname,
        ]);
    }

    public function editRegisterCategory($idCompanyCategory)
    {
        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);
        $param = $this->getParameters();

        $readonlydescription = 0;
        $readonlyname = 0;

        if ($param != null){
            $readonlydescription = $param->readonlydescription;
            $readonlyname = $param->readonlyname;
        }



        $image = $companyCategory->getImage();

        if (!$companyCategory->hasImage())
            $image = asset('/assets/img/category-no-image.png');

        $company = Auth::user()->company();

        return view('company.register.category-form', [
            'categories' => $this->getCategories(),
            'categoriesdetail' => [],//$this->getCategoriesDetails($companyCategory->id),
            'company' => $company,
            'companyCategory' => $companyCategory,
            'images'=> $this->getCompanyCategoryImages($idCompanyCategory),
            'url' => url('register/category/'.$idCompanyCategory.'/update'),
            'tabuser' => true,
            'imgtemp' => CompanyCatImageModel::getTempImages(),
            'urlcompany' => '#',
            'urladdress' => '#',
            'urlcategory' => '#',
            'readonlydescription' => $readonlydescription,
            'readonlyname' => $readonlyname,
        ]);
    }

    public function changeRegisterCategory($idCompanyCategory, RegisterCompanyCategoryFormRequest $request)
    {
        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $companyCategory = CompanyCategory::findOrFail($idCompanyCategory);

        $category = Category::findOrFail($request->input('category_id'));
        $categoryDetail = CategoryDetail::findOrFail($request->input('categorydetail_id'));

        $category_id  = $request->input('category_id');
        $categorydetail_id  = $request->input('categorydetail_id') === '-1' ? null :$request->input('categorydetail_id');

        $name = $request->input('name');
        $description = $request->input('description');

        if ($category->type == 1) {
            $name = $category->name;
            $description = $category->name;
        }
        else {
            $param = $this->getParameters();

            $readonlydescription = 0;
            $readonlyname = 0;

            if ($param != null){
                $readonlydescription = $param->readonlydescription;
                $readonlyname = $param->readonlyname;
            }

            if ($readonlydescription == 1) {
                $description = $categoryDetail->description;
            }

            if ($readonlyname == 1) {
                $name = $categoryDetail->name;
            }
        }

        $value  = $request->input('value');
        $isactive = $request->input('isactive');
        $contract_index = $request->input('contract_index');

        if ($categoryDetail != null) {

            $validator = Validator::make($request->all(), [
                'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
            ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

            if ($validator->fails()) {
                return redirect('register/category/'.$idCompanyCategory.'/change')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        else {
            // 0 - category detail 1 - category contract
            if ($category->type == 0) {

                $validator = Validator::make($request->all(), [
                    'categorydetail_id' => 'required|min:0|integer',
                    'name' => 'required|max:120',
                    'description' => 'required|max:255',
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('register/category/'.$idCompanyCategory.'/change')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            else {
                $validator = Validator::make($request->all(), [
                    'contract_index' => 'required|min:0|integer'
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('register/category/'.$idCompanyCategory.'/change')
                        ->withErrors($validator)
                        ->withInput();
                }

                $value = 0;
                //$name = 'Contrato';
                //$description = '';
            }
        }



        $company = Auth::user()->company();

        $companyCategory->category_id = $category_id ;
        $companyCategory->categorydetail_id = $categorydetail_id;
        $companyCategory->name = $name;
        $companyCategory->description = $description;
        $companyCategory->value = $value;
        $companyCategory->contract_index = $contract_index;
        $companyCategory->isactive = $isactive;


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
        return Redirect::to('/register/category');
    }

    public function addRegisterCategory(RegisterCompanyCategoryFormRequest $request)
    {
        $request->merge(['value' => Utils\ConvDecimal::StrToDecimal($request->input('value'))]);

        $category = Category::findOrFail($request->input('category_id'));
        $categoryDetail = CategoryDetail::find($request->input('categorydetail_id'));

        $company_id  = Auth::user()->company()->id;
        $category_id  = $request->input('category_id');
        $categorydetail_id  = $request->input('categorydetail_id') === '-1' ? null :$request->input('categorydetail_id');

        $name = $request->input('name');
        $description = $request->input('description');

        if ($category->type == 1) {
            $name = $category->name;
            $description = $category->name;
        }
        else {
            $param = $this->getParameters();

            $readonlydescription = 0;
            $readonlyname = 0;

            if ($param != null){
                $readonlydescription = $param->readonlydescription;
                $readonlyname = $param->readonlyname;
            }

            if ($readonlydescription == 1) {
                $description = $categoryDetail->description;
            }

            if ($readonlyname == 1) {
                $name = $categoryDetail->name;
            }
        }


        $value  = $request->input('value');
        $isactive = $request->input('isactive');
        $contract_index = $request->input('contract_index');


        if ($categoryDetail != null) {

            $validator = Validator::make($request->all(), [
                'value' => 'required|numeric|min:'.floatval($categoryDetail->minvalue).'|max:'.floatval($categoryDetail->maxvalue),
            ], $this->messages(floatval($categoryDetail->minvalue), floatval($categoryDetail->maxvalue)));

            if ($validator->fails()) {
                return redirect('register/category')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        else {
            // 0 - category detail 1 - category contract
            if ($category->type == 0) {

                $validator = Validator::make($request->all(), [
                    'categorydetail_id' => 'required|min:0|integer',
                    'name' => 'required|max:120',
                    'description' => 'required|max:255',
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('register/category')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            else {
                $validator = Validator::make($request->all(), [
                    'contract_index' => 'required|min:0|integer'
                ], $this->messages(0, 0));

                if ($validator->fails()) {
                    return redirect('register/category')
                        ->withErrors($validator)
                        ->withInput();
                }

                $value = 0;
                // $name = 'Contrato';
                // $description = '';
            }
        }


        $company = Auth::user()->company();

        $companyCategory = CompanyCategory::create([
            'company_id' => $company_id,
            'category_id' => $category_id,
            'categorydetail_id' => $categorydetail_id,
            'imagepath' => '',
            'imageurl' => '',
            'name' => $name,
            'description' => $description,
            'value' => $value,
            'contract_index' => $contract_index,
            'isactive'=> $isactive,
        ]);

        if (count($request->input('imgdata') ) > 0) {
            CompanyCatImageModel::saveImagesCategory(
                $request->input('imgdata'),
                $company->id,
                $companyCategory->id
            );
        }

        CompanyCatImageModel::clearTempImages();
        return Redirect::to('/register/category');
    }

    public function deleteRegisterCategory($idCompanyCategory)
    {
        try {

            $companyCatImage = CompanyCatImage::where('company_category_id', $idCompanyCategory)->get();
            foreach ($companyCatImage as $image)
            {
                $image->delete();
            }

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

    public function adminRemoveCompany($idCompany)
    {
        $company = Company::findOrFail($idCompany);

        try {

            $user = User::findOrFail($company->user_id);

            $companyCategories = $company->companyCategories;


            foreach($companyCategories as $category)
            {
                $companyCatImage = CompanyCatImage::where('company_category_id', $category->id)->get();
                foreach ($companyCatImage as $image)
                {
                    $image->delete();
                }

                $category->delete();
            }




            $company->delete();

            $user->delete();

            \Session::flash('message_warning', 'Removido com sucesso');

        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                \Session::flash('message_danger', 'Empresa vinculada a outro cadastro.');
            }
        }
        return Redirect::back();
    }



}
