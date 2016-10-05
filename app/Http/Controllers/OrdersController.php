<?php

namespace App\Http\Controllers;

use App\Order;
use App\OutboxOrder;
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
use App\Http\Requests\SaveOutboxOrderRequest;
use Illuminate\Support\Facades\Session;


class OrdersController extends Controller
{

    protected $logged_user;
    
    protected $wall;

    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
        $this->wall = \App::make('authentication_helper');
    }

    /*
     * Вывод страница с приказами (Общая)
     */
    public function index()
    {
        if($this->wall->hasPermission(['_superadmin']))
        {
            $inbox_orders = Order::where('status', null)->orderBy('execute_date')->get();
            $outbox_orders = OutboxOrder::where('status', null)->orderBy('execute_date')->get();
        } 
        else
        {
            $inbox_orders = User::find($this->logged_user->id)->orders_responsible->where('status', null)->sortBy('execute_date');
            $outbox_orders = User::find($this->logged_user->id)->outbox_orders_responsible->where('status', null)->sortBy('execute_date');
        }       
        
        return view('orders.index', compact(
            'inbox_orders',
            'outbox_orders'
        ));
    }

    /*
    * Вывод страницы с входящими приказами
    */
    public function inbox(Request $request)
    {
        // Сохраняем строку параметров в сессии
        $request->session()->put('inboxOrderParamSort', Input::all());

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
        $entity_type = 'App\Order';

        if(count(Order::all()) > 0)
            $last_order_num = Order::orderBy('order_num', 'DESC')->first()->order_num;
        else
            $last_order_num = 0;

        // Создаем черновик
        $order = new Order(array(
            'order_num' => $last_order_num + 1,
            'author_id' => $this->logged_user->id,
            'create_date' => date('d.m.Y'),
            'execute_date' => date('d.m.Y'),
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
        $entity_type = 'App\Order';
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
        $entity_type = 'App\Order';
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

        return redirect()->route('orders.inbox', $request->session()->get('inboxOrderParamSort'));
    }

    /*
     * Сохраняем входящий приказ AJAX
     */
    public function inboxSaveAjax(SaveOrderRequest $request)
    {
        if ($request->id > 0) {

            $order = Order::find($request->id);

            $input = $request->all();

            $order->draft = false;

            $order->status = (isset($input->status)) ? $input->status : null;

            $order->update($input);

            return response(['status' => true, 'action' => 'update']);
        }
        
        return response(['status' => true, 'action' => 'save', 'id' => $order->id, 'slug' => $order->slug]);
    }

    /*
     * Нажатие на кнопку отмена создания входящего приказа
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

            return redirect()->route('orders.inbox', $request->session()->get('inboxOrderParamSort'));
        }
        return redirect()->route('orders.inbox', $request->session()->get('inboxOrderParamSort'));
    }

    // ----------------- Исходящий приказ ------------------
    /*
    * Вывод страницы с исходящими приказами
    */
    public function outbox(Request $request)
    {
        // Сохраняем строку параметров в сессии
        //dd(Input::all());
        
        $request->session()->put('outboxOrderParamSort', Input::all());

        // Сортировка
        if ($request->has('sort') && $request->has('order')) {
            if ($this->wall->hasPermission(['_superadmin'])) {
                $outbox_orders = OutboxOrder::orderBy($request->sort, $request->order)->get();
            } else {
                if ($request->order == 'asc')
                    $outbox_orders = User::find($this->logged_user->id)->outbox_orders_responsible->sortBy($request->sort);
                else
                    $outbox_orders = User::find($this->logged_user->id)->outbox_orders_responsible->sortByDesc($request->sort);
            }
        } else {
            if ($this->wall->hasPermission(['_superadmin'])) {
                $outbox_orders = OutboxOrder::all();
            } else {
                $outbox_orders = User::find($this->logged_user->id)->outbox_orders_responsible;
            }
        }

        $count = count($outbox_orders);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = new Collection($outbox_orders);

        $perPage = config('app_options.count_per_page');

        $currentPageSearchResults = $collection->slice((($currentPage - 1) * $perPage), $perPage)->all();

        $currentPageSearchResults = new LengthAwarePaginator($currentPageSearchResults, $count, $perPage);

        $outbox_orders = $currentPageSearchResults;

        $slice = ((($currentPage - 1) * $perPage) == 0) ? '1' : (($currentPage - 1) * $perPage);
        $perPage = (($currentPage * $perPage) > $count) ? $count : ($currentPage * $perPage);

        return view('orders.outbox', compact('outbox_orders',
            'slice',
            'perPage',
            'count'));
    }

    /**
     * Форма исходящего приказа
     */
    public function outboxCreate()
    {
        $slug = uniqid();
        $entity_type = 'App\OutboxOrder';
        
        if(count(OutboxOrder::all()) > 0)
            $last_outbox_order_num = OutboxOrder::orderBy('outbox_order_num', 'DESC')->first()->outbox_order_num;
        else
            $last_outbox_order_num = 0;

        // Создаем черновик
        $outbox_order = new OutboxOrder(array(
            'outbox_order_num' => $last_outbox_order_num + 1,
            'author_id' => $this->logged_user->id,
            'create_date' => date('d.m.Y'),
            'execute_date' => date('d.m.Y'),
            'slug' => $slug,
            'draft' => true
        ));

        $outbox_order->save();
        $id = $outbox_order->id;
        $draft = $outbox_order->draft;
        $entity = $outbox_order;

        return view('orders.outbox-create', compact('last_outbox_order_num',            
            'id',
            'draft',
            'slug',
            'entity_type',
            'entity'));
    }

    /*
     * Нажатие на кнопку отмена создания исходящего приказа
     */
    public function outboxOrderCancel(Request $request)
    {
        $outbox_order = OutboxOrder::findOrFail($request->id);

        if ($outbox_order->draft == '1') {

            //Удаляем комментарии
            $comments = $outbox_order->comments;

            foreach ($comments as $comment) {
                $comment->delete();
            }

            // Удаляем вложения
            $attachments = $outbox_order->attachments;

            foreach ($attachments as $attachment) {
                $attachment->delete();
            }

            Storage::deleteDirectory('outbox_orders/' . $outbox_order->id);

            $outbox_order->delete();

            return redirect()->route('orders.outbox', $request->session()->get('outboxOrderParamSort'));
        }
        return redirect()->route('orders.outbox', $request->session()->get('outboxOrderParamSort'));
    }

    /*
     * Сохраняем исходящий приказ AJAX
     */
    public function outboxSaveAjax(SaveOutboxOrderRequest $request)
    {
        if ($request->id > 0) {

            $outbox_order = OutboxOrder::find($request->id);

            $input = $request->all();

            $outbox_order->draft = false;

            $outbox_order->status = (isset($input->status)) ? $input->status : null;

            $outbox_order->update($input);

            return response(['status' => true, 'action' => 'update']);
        }
        
        return response(['status' => true, 'action' => 'save', 'id' => $outbox_order->id, 'slug' => $outbox_order->slug]);
    }

    /**
     * Удаление входящего приказа
     */
    public function outboxOrdersDelete($id, Request $request)
    {
        $outbox_order = OutboxOrder::findOrFail($id);

        //Удаляем комментарии
        $comments = $outbox_order->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }

        // Удаляем вложения
        $attachments = $outbox_order->attachments;

        foreach ($attachments as $attachment) {
            $attachment->delete();
        }

        Storage::deleteDirectory('outbox_orders/' . $outbox_order->id);

        $outbox_order->delete();

        Session::flash('flash_message', 'Исходящий приказ успешно удален.');

        return redirect()->route('orders.outbox', $request->session()->get('outboxOrderParamSort'));
    }

    /*
     * Форма простотра исходящего приказа
     */
    public function viewOutbox($id)
    {
        $entity_type = 'App\OutboxOrder';
        $outbox_order = OutboxOrder::findOrFail($id);
        $comments = OutboxOrder::find($id)->comments()->orderBy('created_at', 'desc')->get();

        foreach ($comments as $comment) {
            $comment->user = $comment->user;
            $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
        }

        $entity_id = $outbox_order->slug;       

        // FILES
        if (count($outbox_order->attachments) > 0) {
            $attachments = $outbox_order->attachments;
            $initialPreview = InitialPreview::getInitialPreview($attachments, 'outbox_orders');
            $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
        }
        $append = true;

        $entity = $outbox_order;

        // Получить всех ответственных
        $responsibles = $entity->responsibles;

        return view('orders.outbox-view', compact(
            'entity',
            'entity_id',
            'comments',
            'initialPreview',
            'initialPreviewConfig',
            'append',
            'entity_type',
            'responsibles')
        );
    }

    /*
     * Форма редактирования исходящего приказа
     */
    public function outboxOrdersEdit($id)
    {
        $entity_type = 'App\OutboxOrder';
        $outbox_order = OutboxOrder::findOrFail($id);       

        $comments = OutboxOrder::find($id)->comments()->orderBy('created_at', 'desc')->get();

        foreach ($comments as $comment) {
            $comment->user = $comment->user;
            $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
        }

        $entity_id = $outbox_order->id;        

        // FILES
        if (count($outbox_order->attachments) > 0) {
            $attachments = $outbox_order->attachments;
            $initialPreview = InitialPreview::getInitialPreview($attachments, 'outbox_orders');
            $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
        }
        $append = true;

        $entity = $outbox_order;

        // Получить всех ответственных

        $responsibles = $entity->responsibles;        

        return view('orders.outbox-edit', compact(
            'entity',            
            'entity_id',
            'comments',
            'initialPreview',
            'initialPreviewConfig',
            'append',
            'entity_type',
            'responsibles'));
    }
}