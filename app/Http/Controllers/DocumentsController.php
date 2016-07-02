<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DocumentsController extends Controller
{
     /*
    * Вывод страница с документами (Общая)
    */
   public function index()
   {
        return view('documents.index');
   }

   /*
   * Вывод страницы с входящими документами
   */
   public function inbox()
   {
        return view('documents.inbox');
   }
   /*
   * Вывод страницы с исходящими документами
   */
   public function outbox()
   {
        return view('documents.outbox');
   }
}
