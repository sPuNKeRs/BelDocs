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
    protected $entity_type;

    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
        $this->entity_type = 'orders';
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
    public function inbox(Order $order)
    {
        //$orders = Order::all();

        $orders = $order->paginate(25);
        $count = count($orders);

        return view('orders.inbox', compact('orders', 'count'));
    }

    /*
     * Форма создания входящего приказа
     */
    public function inboxCreate()
    {
        $slug = uniqid();
        $entity_type = $this->entity_type;
        $last_order_num = Order::orderBy('order_num', 'DESC')->first()->order_num;

        // Создаем черновик
        $order = new Order(array(
            'order_num' => $last_order_num + 1,
            'author_id' => $this->logged_user->id,
            'slug' => $slug,
            'draft' => true
        ));

        $order->save();
        $id = $order->id;
        $draft = $order->draft;


        $item_numbers_opt = ItemNumber::getArray();

        return view('orders.inbox-create', compact('last_order_num',
                                                    'item_numbers_opt',
                                                    'id',
                                                    'draft',
                                                    'slug',
                                                    'entity_type'));
    }

    /*
     * Форма редактирования входящего приказа
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $comments = Order::find($id)->comments;

        foreach ($comments as $comment) {
            $comment->user = $comment->user;
            $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
        }

        $entity_id = $order->slug;
        $item_numbers_opt = ItemNumber::getArray();

        return view('orders.inbox-edit', compact('order', 'item_numbers_opt', 'entity_id', 'comments'));
    }

    /**
     * Сохранение изменений входящего приказа
     */
    public function update(SaveOrderRequest $request)
    {
        $order = Order::findOrFail($request->id);

        $input = $request->all();
        //$input['draft'] = NULL;

        if ($order->status != $request->status) $order->status = $request->status;

        $order->fill($input)->save();

        return redirect('/orders/inbox')->with('flash_message', 'Входящий приказ успешно изменен.');
    }

    /**
     * Удаление входящего приказа
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);

        //Удаляем комментарии
        $comments = $order->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }

        $order->delete();

        Session::flash('flash_message', 'Входящий приказ успешно удален.');

        return redirect('/orders/inbox');
    }

    /*
     * Сохраняем входящий приказ AJAX
     */
    public function inboxSaveAjax(SaveOrderRequest $request)
    {
        if ($request->id > 0) {

            $order = Order::find($request->id);

            $input = $request->all();


            $order->update($input);

            return response(['status' => true, 'action' => 'update']);
        }

        $slug = uniqid();
        $order = new Order(array(
            'order_num' => $request->order_num,
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

        return response(['status' => true, 'action' => 'save', 'id' => $order->id, 'slug'=> $order->slug]);
    }

    /*
     * Сохраняем входящий приказ
     */
    public function inboxSave(Request $request)
    {

//       dd($request);


        $slug = uniqid();
        $order = new Order(array(
            'order_num' => $request->order_num,
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

    /*
     * Нажатие на кнопку отмена создания приказа
     */
    public function orderCancel(Request $request)
    {
        $order = Order::findOrFail($request->id);

        if($order->draft == '1'){
            $order->delete();
            return redirect('/orders/inbox');
        }
        return redirect('/orders/inbox');
    }
}