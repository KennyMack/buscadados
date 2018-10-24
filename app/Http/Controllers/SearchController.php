<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryDetail;
use App\City;
use App\Company;
use App\CompanyCategory;
use App\State;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $results = [];
        $company = new Company();
        $type = $request->input('type');
        if (isset($type)) {
            if ($type == 0) {
                $id_state = $request->input('id_state');
                $id_city = $request->input('id_city');
                $id_category = $request->input('id_category');

                $results = $company->where(function ($q) use ($id_state, $id_city, $id_category) {
                    $has_state = is_numeric($id_state);
                    $has_city = is_numeric($id_city);
                    $has_category = is_numeric($id_category);

                    $exists_city = false;
                    $exists_state = false;
                    $exists_category = false;

                    if ($has_city) {
                        $exists_city = City::where('id', $id_city)->count();
                    }

                    if ($has_state) {
                        $exists_state = State::where('id', $id_state)->count();
                    }

                    if ($has_category) {
                        $exists_category = Category::where('id', $id_category)->count();
                    }

                    if ($exists_city > 0) {
                        $q->where('city_id', $id_city);
                    } else if ($exists_state > 0) {
                        $q->WhereHas('city', function ($q) use ($id_state) {
                            $q->where(function ($q) use ($id_state) {
                                $q->where('state_id', $id_state);
                            });
                        });
                    }

                    if ($exists_category > 0) {
                        $q->WhereHas('companyCategories', function ($q) use ($id_category) {
                            $q->where(function ($q) use ($id_category) {
                                $q->where('category_id', $id_category);
                            });
                        });

                        //$q->where('category_id', $id_category);
                    }
                });
            } else {
                $name = $request->input('name');
                $results = $company->search($name);
            }

            $results = $results->where('status', 1);
        }
        else
            $results = $company->where('status', 99);


        return View('search.search-view', [
            'id_state' => $request->input('id_state'),
            'id_city' => $request->input('id_city'),
            'id_category' => $request->input('id_category'),
            'states' => $this->getStates(),
            'categories' => Category::where('isactive', 1)->get(),//$this->getCategoriesDetails(),
            'results' => $results->paginate(10),
            'count_results' => count($results->get()),
            'type' => $request->input('type'),
            'name' => $request->input('name')
        ]);
    }

    public function details($id)
    {
        $company = Company::findOrFail($id);

        return View('search.search-detail', [
            'company' => $company
        ]);
    }

    public function categoryDetail($idCategory)
    {
        $companyCategory = CompanyCategory::findOrFail($idCategory); //->whereNotNull('categorydetail_id');

        $images = $companyCategory->getAllImages()->get();

        return View('search.search-category-detail', [
            'companyCategory' => $companyCategory,
            'images' => $images
        ]);
    }


    private function getCategoriesDetails()
    {
        return CategoryDetail::join('category as cat', 'cat.id', '=', 'category_details.category_id')
            ->where('category_details.isactive', 1)
            ->select('category_details.id', 'category_details.name', 'cat.name as categoryname')
            ->orderBy('cat.name')
            ->orderBy('category_details.name', 'desc')
            ->get();
    }

    private function getStates()
    {
        return State::where('country_id', 1)->get();
    }

    private function getCategories()
    {
        return Category::where('isactive', 1)->orderBy('name')->get();
    }

    private function getCities($state_id)
    {
        return City::where('state_id', $state_id)->orderBy('name')->get();
    }
}
