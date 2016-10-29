<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SearchRequest;

use App\Order;
use App\OutboxOrder;
use App\InboxDocument;
use App\OutboxDocument;
use App\InboxDsp;
use App\OutboxDsp;

class SearchController extends Controller
{
    /*
    * Вывод страница поиска
    */
   public function index()
   {
        return view('search.index');
   }

   /*
    * Начать поиск
    */
    public function go(SearchRequest $request)
    {
        $inbox_orders = Order::search($request->search_query)->get();
        $outbox_orders = OutboxOrder::search($request->search_query)->get();
        $inbox_documents = InboxDocument::search($request->search_query)->get();



        $outbox_documents = OutboxDocument::find(2);
        dd($outbox_documents);

        // $outbox_documents = OutboxDocument::search($request->search_query)->get();
        // dd($outbox_documents);
        // $inbox_dsp = InboxDsp::search($request->search_query)->get();
        // $outbox_dsp = OutboxDsp::search($request->search_query)->get();



        $search_results = $inbox_orders;
        //dd($search_results);


        return view('search.default-search-result', compact(
            'search_results'
        ));
    }
}
