<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use InitialPreview;


use Illuminate\Pagination\LengthAwarePaginator;

use App\ItemNumber;
use App\Sender;
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
        $this->entity_type = 'App\Order';
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
    public function inbox(Request $request)
    {
        // Сохраняем строку параметров в сессии
        $request->session()->put('paramStr', Input::all());

        // Сортировка
        if ($request->has('sort') && $request->has('order')) {
            if ($this->wall->hasPermission(['_superadmin'])) {
                $orders = Order::orderBy($request->sort, $request->order)->get();
            } else {
                if ($request->order == 'asc')
                    $orders = User::find($this->logged_user->id)->orders_responsible->sortBy($request->sort);
                else
                    $orders = User::find($this->logged_user->id)->orders_responsible->sortByDesc($request->sort);
            }
        } else {
            if ($this->wall->hasPermission(['_superadmin'])) {
                $orders = Order::all();
            } else {
                $orders = User::find($this->logged_user->id)->orders_responsible;
            }
        }

        $count = count($orders);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = new Collection($orders);

        $perPage = config('app_options.count_per_page');

        $currentPageSearchResults = $collection->slice((($currentPage - 1) * $perPage), $perPage)->all();

        $currentPageSearchResults = new LengthAwarePaginator($currentPageSearchResults, $count, $perPage);

        $orders = $currentPageSearchResults;

        $slice = ((($currentPage - 1) * $perPage) == 0) ? '1' : (($currentPage - 1) * $perPage);
        $perPage = (($currentPage * $perPage) > $count) ? $count : ($currentPage * $perPage);

        return view('orders.inbox', compact('orders',
            'slice',
            'perPage',
            'count'));
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
        $senders_opt = Sender::getArray();


        return view('orders.inbox-create', compact('last_order_num',
            'item_numbers_opt',
            'senders_opt',
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

        $entity_id = $order->id;
        $item_numbers_opt = ItemNumber::getArray();
        $senders_opt = Sender::getArray();

        // FILES
        if (count($order->attachments) > 0) {
            $attachments = $order->attachments;
            $initialPreview = InitialPreview::getInitialPreview($attachments, 'orders');
            $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
        }
        $append = true;

        $entity = $order;

        // Получить всех ответственных

        $responsibles = $entity->responsibles;        

        return view('orders.inbox-edit', compact('entity',
            'item_numbers_opt',
            'senders_opt',
            'entity_id',
            'comments',
            'initialPreview',
            'initialPreviewConfig',
            'append',
            'entity_type',
            'responsibles'));
    }

    /*
     * Форма простотра входящего приказа
     */
    public function viewInbox($id)
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
        $senders_opt = Sender::getArray();

        // FILES
        if (count($order->attachments) > 0) {
            $attachments = $order->attachments;
            $initialPreview = InitialPreview::getInitialPreview($attachments, 'orders');
            $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
        }
        $append = true;

        $entity = $order;

        // Получить всех ответственных

        $responsibles = $entity->responsibles;
        //dd($responsibles);

        return view('orders.inbox-view', compact('entity',
            'item_numbers_opt',
            'senders_opt',
            'entity_id',
            'comments',
            'initialPreview',
            'initialPreviewConfig',
            'append',
            'entity_type',
            'responsibles'));
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
    public function delete($id, Request $request)
    {
        $order = Order::findOrFail($id);

        //Удаляем комментарии
        $comments = $order->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }

        // Удаляем вложения
        $attachments = $order->attachments;

        foreach ($attachments as $attachment) {
            $attachment->delete();
        }

        Storage::deleteDirectory('orders/' . $order->id);

        $order->delete();

        Session::flash('flash_message', 'Входящий приказ успешно удален.');

        return redirect()->route('orders.inbox', $request->session()->get('paramStr'));
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

        return response(['status' => true, 'action' => 'save', 'id' => $order->id, 'slug' => $order->slug]);
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

        if ($order->draft == '1') {

            //Удаляем комментарии
            $comments = $order->comments;

            foreach ($comments as $comment) {
                $comment->delete();
            }

            // Удаляем вложения
            $attachments = $order->attachments;

            foreach ($attachments as $attachment) {
                $attachment->delete();
            }

            Storage::deleteDirectory('orders/' . $order->id);

            $order->delete();

            return redirect()->route('orders.inbox', $request->session()->get('paramStr'));
        }
        return redirect()->route('orders.inbox', $request->session()->get('paramStr'));
    }
}