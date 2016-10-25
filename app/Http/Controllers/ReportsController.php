<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
       return view('reports.default-report');
   }
}
