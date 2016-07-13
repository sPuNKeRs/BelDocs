<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SaveOrderRequest;

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
    * Форма создания входящего приказа
    */
   public function inboxCreate()
   {
      $lastId = Order::latest()->first()->id;
      return view('orders.inbox-create', compact('lastId'));
   }

   /*
    * Сохраняем входящий приказ
    */
   public function inboxSave(SaveOrderRequest $request)
   {
      $slug = uniqid();
      $order = new Order(array(          
          'item_number' => $request->item_number,
          'incoming_number' => $request->incoming_number,
          'title' => $request->title,
          'create_date' => date($request->create_date),
          'execute_date' => date($request->execute_date),
          'description' => $request->description,
          'status' => $request->status,
          'slug' => $slug
      ));

      $order->save();

      return redirect('/orders/inbox')->with('status', 'Входящий приказ успешно создан.');
   }


   /*
   * Вывод страницы с исходящими приказами
   */
   public function outbox()
   {
        return view('orders.outbox');
   }
}