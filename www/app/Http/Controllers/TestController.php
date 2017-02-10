<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigDataValidation;

class TestController extends Controller
{
    public function getEdit(Request $request)
    {
        $data = $request->session()->get('errors');
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        return view('config.test',['errors'=>$data]);
    }
    public function updateEdit(ConfigDataValidation $request)
    {

    }
}
