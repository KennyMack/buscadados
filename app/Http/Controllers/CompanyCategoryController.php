<?php

namespace App\Http\Controllers;

use App\CompanyCategory;
use App\Http\Requests\CreateCompanyCategoryFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class CompanyCategoryController extends Controller
{
    public function categories($idCompany)
    {
        return CompanyCategory::where('isactive', 1)->where('company_id', $idCompany)->get();
    }

    private function getCompanyCategoryDetails($idCompany)
    {
        return CompanyCategory::where('company_id', $idCompany)->get();
    }

    public function newCompanyCategory($idCompany)
    {
        $categorycompanydetails = $this->getCompanyCategoryDetails($idCompany);

        return view('company.company_category-form', [
            'url' => 'admin/companies/'.$idCompany.'/category/save',
            'idCompany' => $idCompany,
            'categorycompanydetails ' => $categorycompanydetails ,
        ]);
    }

    public function changeCompanyCategory($idCompany, $idcompanycategory)
    {
        $companyCategory = CompanyCategory::findOrFail($idcompanycategory);
        $categorycompanydetails = $this->getCompanyCategoryDetails($idCompany);

        return view('company.company_category-form', [
            'companyCategory' => $companyCategory,
            'categorycompanydetails' => $categorycompanydetails,
            'url' => 'admin/companies/'.$idCompany.'/category/'.$idcompanycategory.'/update',
            'idCategory' => $idCompany
        ]);
    }


    public function saveCompanyCategory($idCompany, CreateCompanyCategoryFormRequest $request)
    {
        $companyCategory = new CompanyCategory();

        $companyCategory = $companyCategory->create([
            'company_id'=> $idCompany,
            'categorydetail_id'=> $request->input('categorydetail_id'),
            'imagepath' => '',//$request->input('imagepath'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'value' => $request->input('value'),
            'isactive' => $request->input('isactive')
        ]);

        \Session::flash('message_detail_success', 'Salvo com sucesso');

        return Redirect::to('admin/companies/'.$idCompany.'/category/create');
    }

    public function updateCompanyCategory($idCompany, $idcompanycategory, CreateCompanyCategoryFormRequest $request)
    {
        $companyCategory = CompanyCategory::findOrFail($idcompanycategory);

        $companyCategory->company_id = $idCompany;
        $companyCategory->categorydetail_id = $request->input('categorydetail_id');;
        $companyCategory->imagepath = '';// $request->input('name');
        $companyCategory->name = $request->input('name');
        $companyCategory->description = $request->input('description');
        $companyCategory->value = $request->input('value');
        $companyCategory->isactive = $request->input('isactive');

        $companyCategory->save();

        \Session::flash('message_detail_success', 'Atualizado com sucesso');

        return Redirect::to('admin/companies/'.$idCompany.'/category/create');
    }

    public function deleteCompanyCategory($idCompany, $idcompanycategory)
    {
        try {

            /* checks whether company has this category detail */

            $categoryDetail = CompanyCategory::findOrFail($idcompanycategory);

            $categoryDetail->delete();

            \Session::flash('message_detail_warning', 'Removido com sucesso');

        } catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                \Session::flash('message_danger', 'Existem empresas vinculadas a esta categoria.');
            }
        }
        return Redirect::to('admin/companies/' . $idCompany . '/category/create');

    }
}
