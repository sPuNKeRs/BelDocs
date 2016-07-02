<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    // Главная страница
    public function mainpage ()
    { 
    	// $authentication = \App::make('authenticator');
    	// $logged_user = $authentication->getLoggedUser();    	
    	return view('mainpage');
    }

    // Приказы
    public function orders_all()
    {
    	// $authentication = \App::make('authenticator');
    	// $logged_user = $authentication->getLoggedUser();    	
    	return view('orders.all');
    }
    
}
