<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;
use Markdown;

class ChangelogController extends Controller
{
    public function index()
    {
        // TODO make this to database
    	$folder = '../../updates/';
    	$upcoming_features = file_get_contents($folder.'upcoming_features');
    	$changelog = file_get_contents($folder.'changelog');

    	return view('changelog', [
    			'upcoming_features' => Markdown::parse($upcoming_features),
    			'changelog' => Markdown::parse($changelog)
    		]);
    }
}
