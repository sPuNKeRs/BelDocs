<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class OrdersController extends Controller
{
   /*
    * Вывод страница с приказами (Общая)
    */
   public function index()
   {
        return view('orders.index');
   }

   /*
   * Вывод страницы с входящими приказами
   */
   public function inbox()
   {
        return view('orders.inbox');
   }
   /*
   * Вывод страницы с исходящими приказами
   */
   public function outbox()
   {
        return view('orders.outbox');
   }
}