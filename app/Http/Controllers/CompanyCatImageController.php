<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CompanyCatImageController extends Controller
{
    public function remove($id) {
        try {

            $companyCatImageController = CompanyCatImageController::findOrFail($id);

            $companyCatImageController->delete();

        } catch (\Exception $e) {

        }
        return '{"ok" = "true"}';
    }
}
