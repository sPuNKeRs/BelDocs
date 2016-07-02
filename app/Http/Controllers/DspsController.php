<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DspsController extends Controller
{
   /*
    * Вывод страница с ДСП (Общая)
    */
   public function index()
   {
        return view('dsp.index');
   }

   /*
   * Вывод страницы с ДСП
   */
   public function inbox()
   {
        return view('dsp.inbox');
   }
   /*
   * Вывод страницы с исходящими приказами
   */
   public function outbox()
   {
        return view('dsp.outbox');
   }
}
