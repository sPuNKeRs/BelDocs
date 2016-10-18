<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Http\Requests;
use App\InboxDsp;
use App\OutboxDsp;

class DspsController extends Controller
{
  protected $logged_user;
  protected $wall;

  public function __construct()
  {
    $this->logged_user = \App::make('authenticator')->getLoggedUser();
    $this->wall = \App::make('authentication_helper');
  }

   /*
    * Вывод страница с ДСП (Общая)
    */
   public function index()
   {
        return view('dsp.index');
   }

   // --------------------------------------------------------
   // -----------------  Входящие ДСП ------------------------
   // --------------------------------------------------------

   /*
   * Вывод страницы с входящими ДСП
   */
   public function inbox(Request $request)
   {
    // Сохраняем строку параметров в сессии
    $request->session()->put('inboxDspsParamSort', Input::all());

    // Сортировка
    if ($request->has('sort') && $request->has('order')) {
          if ($this->wall->hasPermission(['_superadmin'])) {
              $inbox_dsps = InboxDsp::orderBy($request->sort, $request->order)->get();
          } else {
              if ($request->order == 'asc')
                  $inbox_dsps = User::find($this->logged_user->id)->inbox_dsps_responsible->sortBy($request->sort);
              else
                  $inbox_dsps = User::find($this->logged_user->id)->inbox_dsps_responsible->sortByDesc($request->sort);
          }
      } else {
          if ($this->wall->hasPermission(['_superadmin'])) {
              $inbox_dsps = InboxDsp::all();
          } else {
              $inbox_dsps = User::find($this->logged_user->id)->inbox_dsps_responsible;
          }
      }

      $count = count($inbox_dsps);
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $collection = new Collection($inbox_dsps);
      $perPage = config('app_options.count_per_page');
      $currentPageSearchResults = $collection->slice((($currentPage - 1) * $perPage), $perPage)->all();
      $currentPageSearchResults = new LengthAwarePaginator($currentPageSearchResults, $count, $perPage);
      $inbox_dsps = $currentPageSearchResults;
      $slice = ((($currentPage - 1) * $perPage) == 0) ? '1' : (($currentPage - 1) * $perPage);
      $perPage = (($currentPage * $perPage) > $count) ? $count : ($currentPage * $perPage);

      return view('dsp.inbox', compact(
        'inbox_dsps',
        'slice',
        'perPage',
        'count')
      );
   }

   /*
    * Форма создания входящего ДСП
    */
   public function inboxCreate()
   {

   }

   /*
    * Созранение входящего ДСП
    */
   public function inboxSave()
   {

   }

   /*
    * Форма редактирования входящего ДСП
    */
   public function inboxEdit()
   {

   }

   /*
    * Удаление входящего ДСП
    */
   public function inboxDelete()
   {

   }

   /*
    * Форма просмотра входящего ДСП
    */
   public function inboxView()
   {

   }

   /*
    * Отмена создания входящего ДСП
    */
   public function inboxCancel()
   {

   }
   // ---------------------------------------------------
   // ----------------  Исходящие ДСП -------------------
   // ---------------------------------------------------

   /*
   * Вывод страницы с исходящими ДСП
   */
   public function outbox()
   {
        return view('dsp.outbox');
   }

   /*
    * Форма создания исходящего ДСП
    */
   public function outboxCreate()
   {

   }

   /*
    * Созранение исходящего ДСП
    */
   public function outboxSave()
   {

   }

   /*
    * Форма редактирования исходящего ДСП
    */
   public function outboxEdit()
   {

   }

   /*
    * Удаление исходящего ДСП
    */
   public function outboxDelete()
   {

   }

   /*
    * Форма просмотра исходящего ДСП
    */
   public function outboxView()
   {

   }

   /*
    * Отмена создания исходящего ДСП
    */
   public function outboxCancel()
   {

   }
}
