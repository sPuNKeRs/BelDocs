<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use InitialPreview;

use App\ItemNumber;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SaveOrderRequest;
use Illuminate\Support\Facades\Session;


class OrdersController extends Controller
{

    protected $logged_user;
    protected $entity_type;
    protected $wall;

    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
        $this->wall = \App::make('authentication_helper');
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
        if($this->wall->hasPermission(['_superadmin']))
        {
            $orders = Order::all();
        }
        else
        {
            $orders = User::find($this->logged_user->id)->orders_responsible;
        }

        // $orders = $order->paginate(25);
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
        $entity = $order;


        $item_numbers_opt = ItemNumber::getArray();

        return view('orders.inbox-create', compact('last_order_num',
                                                    'item_numbers_opt',
                                                    'id',
                                                    'draft',
                                                    'slug',
                                                    'entity_type',
                                                    'entity'));
    }

    /*
     * Форма редактирования входящего приказа
     */
    public function edit($id)
    {
        $entity_type = $this->entity_type;
        $order = Order::findOrFail($id);
        $comments = Order::find($id)->comments()->orderBy('created_at', 'desc')->get();

        foreach ($comments as $comment) {
            $comment->user = $comment->user;
            $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
        }

        $entity_id = $order->slug;
        $item_numbers_opt = ItemNumber::getArray();

        // FILES
        if(count($order->attachments) > 0)
        {
            $attachments = $order->attachments;
            $initialPreview = InitialPreview::getInitialPreview($attachments, 'orders');
            $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
        }
        $append = true;

        $entity = $order;
        
        //dd($entity);
        
        return view('orders.inbox-edit', compact('entity',
                                                'item_numbers_opt',
                                                'entity_id',
                                                'comments',
                                                'initialPreview',
                                                'initialPreviewConfig',
                                                'append',
                                                'entity_type'));
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

        // Удаляем вложения
        $attachments = $order->attachments;

        foreach ($attachments as $attachment)
        {
            $attachment->delete();
        }

        Storage::deleteDirectory('orders/'.$order->slug);

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
            'resolution' => $request->resolution,
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
        $slug = uniqid();
        $order = new Order(array(
            'order_num' => $request->order_num,
            'item_number' => $request->item_number,
            'incoming_number' => $request->incoming_number,
            'title' => $request->title,
            'create_date' => date($request->create_date),
            'execute_date' => date($request->execute_date),
            'description' => $request->description,
            'resolution' => $request->resolution,
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

            //Удаляем комментарии
            $comments = $order->comments;

            foreach ($comments as $comment) {
                $comment->delete();
            }

            // Удаляем вложения
            $attachments = $order->attachments;

            foreach ($attachments as $attachment)
            {
                $attachment->delete();
            }

            Storage::deleteDirectory('orders/'.$order->slug);

            $order->delete();

            return redirect('/orders/inbox');
        }
        return redirect('/orders/inbox');
    }
}