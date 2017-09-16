<?php

namespace App\Http\Controllers;

use App\CategoryDetail;
use App\Http\Requests\CreateCategoryDetailFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class CategoryDetailController extends Controller
{
    public function details($idCategory)
    {
        return CategoryDetail::where('isactive', 1)->where('category_id', $idCategory)->get();
    }

    private function getCategoryDetails($idCategory)
    {
        return CategoryDetail::where('category_id', $idCategory)->get();
    }

    public function newCategoryDetail($idCategory)
    {
        $categorydetails = $this->getCategoryDetails($idCategory);

        return view('category.category_detail-form', [
            'url' => 'admin/categories/'.$idCategory.'/detail/save',
            'idCategory' => $idCategory,
            'categorydetails' => $categorydetails,
        ]);
    }

    public function changeCategoryDetail($idCategory, $idDetail)
    {
        $categoryDetail = CategoryDetail::findOrFail($idDetail);
        $categorydetails = $this->getCategoryDetails($idCategory);

        return view('category.category_detail-form', [
            'categoryDetail' => $categoryDetail,
            'categorydetails' => $categorydetails,
            'url' => 'admin/categories/'.$idCategory.'/detail/'.$idDetail.'/update',
            'idCategory' => $idCategory
        ]);
    }


    public function saveCategoryDetail($idCategory, CreateCategoryDetailFormRequest $request)
    {
        $categoryDetail = new CategoryDetail();

        $categoryDetail = $categoryDetail->create([
            'name'=> $request->input('name'),
            'minvalue' => $request->input('minvalue'),
            'maxvalue' => $request->input('maxvalue'),
            'isactive' => $request->input('isactive'),
            'category_id' => $idCategory,
        ]);

        \Session::flash('message_detail_success', 'Salvo com sucesso');

        return Redirect::to('admin/categories/'.$idCategory.'/detail/create');
    }

    public function updateCategoryDetail($idCategory, $idDetail, CreateCategoryDetailFormRequest $request)
    {
        $categoryDetail = CategoryDetail::findOrFail($idDetail);

        $categoryDetail->name = $request->input('name');
        $categoryDetail->isactive = $request->input('isactive');
        $categoryDetail->category_id = $idCategory;
        $categoryDetail->minvalue = $request->input('minvalue');
        $categoryDetail->maxvalue = $request->input('maxvalue');

        $categoryDetail->save();

        \Session::flash('message_detail_success', 'Atualizado com sucesso');

        return Redirect::to('admin/categories/'.$idCategory.'/detail/create');
    }

    public function deleteCategoryDetail($idCategory, $idDetail)
    {
        try {

            /* checks whether company has this category detail */

            $categoryDetail = CategoryDetail::findOrFail($idDetail);

            $categoryDetail->delete();

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
        return Redirect::to('admin/categories/' . $idCategory . '/detail/create');

    }

    public function categoryDetails($category_id)
    {
        return \Response::json(CategoryDetail::where('category_id', $category_id)->where('isactive', 1)->orderBy('name', 'asc')->get());
    }
}
