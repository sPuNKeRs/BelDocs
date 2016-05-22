<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    // Главная страница
    public function mainpage ()
    { 
    	$authentication = \App::make('authenticator');
    	$logged_user = $authentication->getLoggedUser();
    	return view('mainpage', [
    		'logged_user' => $logged_user
    	]);
    }

    
}
