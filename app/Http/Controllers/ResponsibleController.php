<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Responsible;
use App\Order;
use App\User;


class ResponsibleController extends Controller
{    
    public function index()
    {

    }

    public function store()
    {

//        $responsible = new Responsible();
//        $responsible->entity_id = 406;
//        $responsible->entity_type = 'App\Order';
//        $responsible->user_id = \App::make('authenticator')->getLoggedUser()->id;
//        $responsible->executed_at = Carbon::today();
//        $responsible->status = false;
//
//        $responsible->save();
        
      // $order = Order::find(3);
       // $responsibles = $order->responsibles;
//
//        dd($responsibles);

        $user = User::find('1');
        $responsibles = $user->orders_responsible;
//
////        foreach ($responsibles as $resp)
////        {
////            echo $resp->entity->title."<br>";
////        }
//
        dd($responsibles);


    }

    public function destroy()
    {

    }
}
