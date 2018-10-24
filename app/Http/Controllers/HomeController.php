<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'categories' => Category::where('isactive', 1)->orderby('icon')->get(),
        ]);
    }

    public static function getCategoryId($index)
    {
        $cat = Category::where('icon', $index)->get();
        if ($cat != null &&
            count($cat) > 0)
            return $cat[0]->id;

        return -1;
    }
}
