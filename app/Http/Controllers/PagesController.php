<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    // Главная страница
    public function mainpage ()
    {
        return view('mainpage');
    }
}