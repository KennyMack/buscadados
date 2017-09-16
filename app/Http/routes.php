<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Http\Requests;
use Illuminate\Http\Request;



Route::auth();

Route::group(['prefix' => '', 'middleware' => ['complete']], function () {
    Route::get('/home', 'HomeController@index');
});
Route::get('/', function() {
    return View('welcome');
});

Route::group(['prefix' => 'admin/users', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'Auth\UserController@index');
    Route::get('/create', 'Auth\UserController@newUser');
    Route::get('/{id}/change', 'Auth\UserController@changeUser');
    Route::post('/save', 'Auth\UserController@saveUser');
    Route::put('/{id}/update', 'Auth\UserController@updateUser');
    Route::delete('/{id}/remove', 'Auth\UserController@deleteUser');

});

Route::group(['prefix' => 'admin/categories', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'CategoryController@index');
    Route::get('/create', 'CategoryController@newCategory');
    Route::get('/{id}/change', 'CategoryController@changeCategory');
    Route::post('/save', 'CategoryController@saveCategory');
    Route::put('/{id}/update', 'CategoryController@updateCategory');
    Route::delete('/{id}/remove', 'CategoryController@deleteCategory');


    /* get categories detail from category id */
    Route::get('/{id}/details', 'CategoryDetailController@details');

    /* get create page detail with category id */
    Route::get('/{id}/detail/create', 'CategoryDetailController@newCategoryDetail');

    /* post to save create page detail with category id */
    Route::post('/{id}/detail/save', 'CategoryDetailController@saveCategoryDetail');

    /* get category page detail with category id */
    Route::get('/{id}/detail/{iddetail}/change', 'CategoryDetailController@changeCategoryDetail');

    /* put to update category detail with category id and category id detail */
    Route::put('/{id}/detail/{iddetail}/update', 'CategoryDetailController@updateCategoryDetail');

    /* delete to remove category detail with category id and category id detail */
    Route::delete('/{id}/detail/{iddetail}/remove', 'CategoryDetailController@deleteCategoryDetail');

});

Route::group(['prefix' => 'admin/countries', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'CountryController@index');
    Route::get('/create', 'CountryController@newCountry');
    Route::get('/{id}/change', 'CountryController@changeCountry');
    Route::post('/save', 'CountryController@saveCountry');
    Route::put('/{id}/update', 'CountryController@updateCountry');
    Route::delete('/{id}/remove', 'CountryController@deleteCountry');
});

Route::group(['prefix' => 'admin/states', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'StateController@index');
    Route::get('/create', 'StateController@newState');
    Route::get('/{id}/change', 'StateController@changeState');
    Route::post('/save', 'StateController@saveState');
    Route::put('/{id}/update', 'StateController@updateState');
    Route::delete('/{id}/remove', 'StateController@deleteState');
});

Route::group(['prefix' => 'admin/cities', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'CityController@index');
    Route::get('/create', 'CityController@newCity');
    Route::get('/{id}/change', 'CityController@changeCity');
    Route::post('/save', 'CityController@saveCity');
    Route::put('/{id}/update', 'CityController@updateCity');
    Route::delete('/{id}/remove', 'CityController@deleteCity');
});



Route::group(['prefix' => 'api'], function () {
    Route::get('country/{country_id}/state/{state_id}/cities', 'CityController@cities');
    Route::get('country/{country_id}/states', 'StateController@states');
    Route::get('countries', 'CountryController@countries');
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category_id}/detail', 'CategoryDetailController@categoryDetails');






});

Route::group(['prefix' => 'admin/companies', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'CompanyController@index');
    Route::get('/{id}/details', 'CompanyController@details');
    Route::post('/{id}/enable', 'CompanyController@enable');
    Route::post('/{id}/disable', 'CompanyController@disable');
    Route::get('/disabled', 'CompanyController@companiesDisabled');

    Route::delete('/{id}/remove', 'CompanyController@adminRemoveCompany');


    /* get categories detail from category id */
    Route::get('/{idcompany}/categories', 'CompanyCategoryController@categories');

    /* get create page detail with category id */
    Route::get('/{idcompany}/category/create', 'CompanyCategoryController@newCompanyCategory');

    /* post to save create page detail with category id */
    Route::post('/{idcompany}/category/save', 'CompanyCategoryController@saveCompanyCategory');

    /* get category page detail with category id */
    Route::get('/{idcompany}/category/{idcompanycategory}/change', 'CompanyCategoryController@changeCompanyCategory');

    /* put to update category detail with category id and category id detail */
    Route::put('/{idcompany}/category/{idcompanycategory}/update', 'CompanyCategoryController@updateCompanyCategory');

    /* delete to remove category detail with category id and category id detail */
    Route::delete('/{idcompany}/category/{idcompanycategory}/remove', 'CompanyCategoryController@deleteCompanyCategory');

});

Route::group(['prefix' => 'register', 'middleware' => ['auth', 'wasenabled']], function () {
    Route::get('/company', 'CompanyController@registerCompany');
    Route::post('/company/save', 'CompanyController@saveRegisterCompany');

    Route::get('/address', 'CompanyController@registerAddress');
    Route::post('/address/save', 'CompanyController@saveRegisterAddress');

    Route::get('/category', 'CompanyController@registerCategory');
    Route::get('/category/{id}/change', 'CompanyController@editRegisterCategory');
    Route::put('/category/{id}/update', 'CompanyController@changeRegisterCategory');


    Route::post('/category/add', 'CompanyController@addRegisterCategory');
    Route::delete('/category/{id}/remove', 'CompanyController@deleteRegisterCategory');

    Route::post('/category/save', 'CompanyController@saveRegisterCategory');

    Route::post('/category/image/{id}/remove', 'CompanyCatImageController@remove');

});

Route::group(['prefix' => 'companies', 'middleware' => ['auth', 'complete']], function () {



    Route::get('/profile/company', 'CompanyController@profileCompany');
    Route::post('/profile/company/save', 'CompanyController@saveProfileCompany');

    Route::get('/profile/address', 'CompanyController@profileAddress');
    Route::post('/profile/address/save', 'CompanyController@saveProfileAddress');

    Route::get('/profile/category', 'CompanyController@profileCategory');
    Route::get('/profile/category/{id}/change', 'CompanyController@editProfileCategory');
    Route::put('/profile/category/{id}/update', 'CompanyController@changeProfileCategory');


    Route::post('/profile/category/add', 'CompanyController@addProfileCategory');
    Route::delete('/profile/category/{id}/remove', 'CompanyController@deleteProfileCategory');


    Route::post('/profile/category/save', 'CompanyController@saveProfileCategory');

    Route::post('/category/image/{id}/remove', 'CompanyCatImageController@remove');



    /* get categories detail from category id */
    Route::get('/{idcompany}/categories', 'CompanyCategoryController@categories');

    /* get create page detail with category id */
    Route::get('/{idcompany}/category/create', 'CompanyCategoryController@newCompanyCategory');

    /* post to save create page detail with category id */
    Route::post('/{idcompany}/category/save', 'CompanyCategoryController@saveCompanyCategory');

    /* get category page detail with category id */
    Route::get('/{idcompany}/category/{idcompanycategory}/change', 'CompanyCategoryController@changeCompanyCategory');

    /* put to update category detail with category id and category id detail */
    Route::put('/{idcompany}/category/{idcompanycategory}/update', 'CompanyCategoryController@updateCompanyCategory');

    /* delete to remove category detail with category id and category id detail */
    Route::delete('/{idcompany}/category/{idcompanycategory}/remove', 'CompanyCategoryController@deleteCompanyCategory');

});

Route::group([ 'middleware' => ['auth', 'complete']], function () {
    Route::get('/search', 'SearchController@index');
    Route::get('/search/{id}', 'SearchController@details');
    Route::get('/search/{id}/detail', 'SearchController@categoryDetail');
});