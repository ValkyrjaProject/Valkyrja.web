<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TeamController extends Controller
{
    /**
     * Team page
     */
    public function index(){
        return view('team');
    }
}
