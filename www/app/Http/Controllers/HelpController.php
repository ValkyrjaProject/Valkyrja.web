<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HelpController extends Controller
{
    /**
    * Valkyrja features page.
    */
    public function index(){
        return view('help');
    }
}
