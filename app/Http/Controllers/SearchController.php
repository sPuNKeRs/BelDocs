<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SearchRequest;

use App\Order;

class SearchController extends Controller
{
    /*
    * Вывод страница поиска
    */
   public function index()
   {
        //$order = Order::search('11121 PuNKeR')->get();
        //dd($order);

        return view('search.index');
   }

   /*
    * Начать поиск
    */
    public function go(SearchRequest $request)
    {
        $inbox_orders = Order::search($request->search_query)->get();


        $search_results = $inbox_orders;
        //dd($search_results);


        return view('search.default-search-result', compact(
            'search_results'
        ));
    }
}
