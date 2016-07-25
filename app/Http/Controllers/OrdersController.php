<?php

namespace App\Http\Controllers;

use App\Order;
use App\ItemNumber;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SaveOrderRequest;
use Illuminate\Support\Facades\Session;


class OrdersController extends Controller
{

    protected $logged_user;

    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
    }

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
         $orders = Order::all();
         $count = count($orders);
         
        return view('orders.inbox', compact('orders' , 'count'));
   }

   /*
    * Форма создания входящего приказа
    */
   public function inboxCreate()
   {
      $lastId = Order::latest()->first()->id;

      $item_numbers_opt = ItemNumber::getArray();

      return view('orders.inbox-create', compact('lastId' , 'item_numbers_opt'));
   }

   /*
    * Форма редактирования входящего приказа
    */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $item_numbers_opt = ItemNumber::getArray();

        return view('orders.inbox-edit', compact('order', 'item_numbers_opt'));
    }

    /**
     * Сохранение изменений входящего приказа
     */
    public function update(SaveOrderRequest $request)
    {
        $order = Order::findOrFail($request->id);
        $input = $request->all();

        if($order->status != $request->status) $order->status = $request->status;

        $order->fill($input)->save();

        return redirect('/orders/inbox')->with('flash_message', 'Входящий приказ успешно изменен.');

    }

    /**
     * Удаление входящего приказа
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        Session::flash('flash_message', 'Входящий приказ успешно удален.');

        return redirect('/orders/inbox');
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
          'author_id' => $this->logged_user->id,
          'slug' => $slug
      ));

      $order->save();

      return redirect('/orders/inbox')->with('flash_message', 'Входящий приказ успешно создан.');
   }


   /*
   * Вывод страницы с исходящими приказами
   */
   public function outbox()
   {
        return view('orders.outbox');
   }
}