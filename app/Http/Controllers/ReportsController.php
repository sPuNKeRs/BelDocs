<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Collection;
use Carbon\Carbon;

use App\Helpers\ReportsHelper;

use App\Order;
use App\OutboxOrder;
use App\InboxDocument;
use App\OutboxDocument;
use App\InboxDsp;
use App\OutboxDsp;

class ReportsController extends Controller
{
    /*
    * Вывод страница с отчетами
    */
   public function index()
   {
        // Массив с типами документов
        $entity_type = ReportsHelper::getEntityType();


        // Вывод страницы отчетов
        return view('reports.index', compact(
            'entity_type'
        ));
   }

   // Формирование отчета
   public function generate(Request $request)
   {
       // Инициализация переменных
       $entity_type = $request->entity_type_id;
       $from_date = Carbon::createFromFormat('d.m.Y', $request->from_date);
       $by_date = Carbon::createFromFormat('d.m.Y', $request->by_date);

       switch ($entity_type) {
           case 'io_orders':

               $inbox_orders = Order::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();
               $outbox_orders = OutboxOrder::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

               $collection = new Collection();
               $all = $collection->merge($inbox_orders)->merge($outbox_orders);
               $entity_type = 'Все приказы';
               $entitys =  $all;
           break;

           case 'i_orders':
                $entity_type = 'Входящие приказы';
                $entitys = Order::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();
           break;

           case 'o_orders':
                $entity_type = 'Исходящие приказы';
                $entitys = OutboxOrder::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();
           break;

           case 'io_documents':
                $inbox_documents = InboxDocument::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();
                $outbox_documents = OutboxDocument::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

                $collection = new Collection();
                $all = $collection->merge($inbox_documents)->merge($outbox_documents);

                $entity_type = 'Все документы';
                $entitys = $all;
           break;

           case 'i_documents':
                $inbox_documents = InboxDocument::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

                $entity_type = 'Входящие документы';
                $entitys = $inbox_documents;
           break;

           case 'o_documents':
                $outbox_documents = OutboxDocument::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

                $entity_type = 'Исходящие документы';
                $entitys = $outbox_documents;
           break;

           case 'io_dsp':
                $inbox_dsp = InboxDsp::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();
                $outbox_dsp = OutboxDsp::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

                $collection = new Collection();
                $all = $collection->merge($inbox_dsp)->merge($outbox_dsp);

                $entity_type = 'Все ДСП';
                $entitys = $all;
           break;

           case 'i_dsp':
                $inbox_dsp = InboxDsp::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

                $entity_type = 'Входящие ДСП';
                $entitys = $inbox_dsp;
           break;

           case 'o_dsp':
                $outbox_dsp = OutboxDsp::where('create_date', '>=', $from_date->toDateString())->where('create_date','<=',$by_date->toDateString())->get();

                $entity_type = 'Исходящие ДСП';
                $entitys = $outbox_dsp;
           break;
       }


       return view('reports.default-report', compact(
           'entitys',
           'entity_type',
           'from_date',
           'by_date')
       );
   }
}
