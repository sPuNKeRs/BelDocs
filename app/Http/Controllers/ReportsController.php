<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReportsController extends Controller
{
    /*
    * Вывод страница с отчетами
    */
   public function index()
   {
        return view('reports.index');
   }
}
