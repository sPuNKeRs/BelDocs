<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\Order;
use App\OutboxOrder;
use App\InboxDocument;
use App\OutboxDocument;
use App\InboxDsp;
use App\OutboxDsp;

class PagesController extends Controller
{
    protected $logged_user;    
    protected $wall;

    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
        $this->wall = \App::make('authentication_helper');
    }

    // Главная страница
    public function mainpage ()
    {
        if($this->wall->hasPermission(['_superadmin']))
        {
            $inbox_orders = Order::where('status', null)->orderBy('execute_date')->get();
            $outbox_orders = OutboxOrder::where('status', null)->orderBy('execute_date')->get();

            $inbox_documents = InboxDocument::where('status', null)->orderBy('execute_date')->get();
            $outbox_documents = OutboxDocument::where('status', null)->orderBy('execute_date')->get();

            $inbox_dsps = InboxDsp::where('status', null)->orderBy('execute_date')->get();
            $outbox_dsps = OutboxDsp::where('status', null)->orderBy('execute_date')->get();

        } 
        else
        {
            $inbox_orders = User::find($this->logged_user->id)->orders_responsible->where('status', null)->sortBy('execute_date');
            $outbox_orders = User::find($this->logged_user->id)->outbox_orders_responsible->where('status', null)->sortBy('execute_date');

            $inbox_documents = User::find($this->logged_user->id)->inbox_documents_responsible->where('status', null)->sortBy('execute_date');
            $outbox_documents = User::find($this->logged_user->id)->outbox_documents_responsible->where('status', null)->sortBy('execute_date');

            $inbox_dsps = User::find($this->logged_user->id)->inbox_dsps_responsible->where('status', null)->sortBy('execute_date');
            $outbox_dsps = User::find($this->logged_user->id)->outbox_dsps_responsible->where('status', null)->sortBy('execute_date');


        }       
        
        return view('mainpage', compact(
            'inbox_orders',
            'outbox_orders',
            'inbox_documents',
            'outbox_documents',
            'inbox_dsps',
            'outbox_dsps'
        ));        
    }
}