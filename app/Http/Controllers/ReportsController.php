<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Collection;

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
        $entity_type = array(
            'io_orders' => 'Приказы',
            'i_orders' => 'Входящие приказы',
            'o_orders' => 'Исходящие приказы',
            'io_documents' => 'Документы',
            'i_documents' => 'Входящие документы',
            'o_documents' => 'Исходящие документы',
            'io_dsp' => 'ДСП',
            'i_dsp' => 'Входящие ДСП',
            'o_dsp' => 'Исходящие ДСП'
        );


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
       $from_date = $request->from_date;
       $by_date = $request->by_date;


       switch ($entity_type) {
           case 'io_orders':

               $inbox_orders = Order::all();
               $outbox_orders = OutboxOrder::all();

               $collection = new Collection();
               $all = $collection->merge($inbox_orders)->merge($outbox_orders);
               $entity_type = 'Все приказы';
               $entitys =  $all;
           break;

           case 'i_orders':
                $entity_type = 'Входящие приказы';
                $entitys = Order::all();
           break;

           case 'o_orders':
                $entity_type = 'Исходящие приказы';
                $entitys = OutboxOrder::all();
           break;

           case 'io_documents':
                $inbox_documents = InboxDocument::all();
                $outbox_documents = OutboxDocument::all();

                $collection = new Collection();
                $all = $collection->merge($inbox_documents)->merge($outbox_documents);

                $entity_type = 'Все документы';
                $entitys = $all;
           break;

           case 'i_documents':
                $inbox_documents = InboxDocument::all();

                $entity_type = 'Входящие документы';
                $entitys = $inbox_documents;
           break;

           case 'o_documents':
                $outbox_documents = OutboxDocument::all();

                $entity_type = 'Исходящие документы';
                $entitys = $outbox_documents;
           break;

           case 'io_dsp':
                $inbox_dsp = InboxDsp::all();
                $outbox_dsp = OutboxDsp::all();

                $collection = new Collection();
                $all = $collection->merge($inbox_dsp)->merge($outbox_dsp);

                $entity_type = 'Все ДСП';
                $entitys = $all;
           break;

           case 'i_dsp':
                $inbox_dsp = InboxDsp::all();

                $entity_type = 'Входящие ДСП';
                $entitys = $inbox_dsp;
           break;

           case 'o_dsp':
                $outbox_dsp = OutboxDsp::all();

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
