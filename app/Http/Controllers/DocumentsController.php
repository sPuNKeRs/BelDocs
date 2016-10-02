<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use App\InboxDocument;
use App\OutboxDocument;



class DocumentsController extends Controller
{
  protected $logged_user;
  protected $wall;

  public function __construct()
  {
    $this->logged_user = \App::make('authenticator')->getLoggedUser();
    $this->wall = \App::make('authentication_helper');
  }

   /*
    * Вывод страница с документами (Общая)
    */
   public function index()
   {
        return view('documents.index');
   }

   // --------------------------------------------------------
   // -----------------  Входящие документы ------------------
   // --------------------------------------------------------

   /*
   * Вывод страницы с входящими документами
   */
   public function inbox(Request $request)
   {
      // Сохраняем строку параметров в сессии
      $request->session()->put('inboxDocumetsParamSort', Input::all());

      // Сортировка
      if ($request->has('sort') && $request->has('order')) {
            if ($this->wall->hasPermission(['_superadmin'])) {
                $inbox_documents = InboxDocument::orderBy($request->sort, $request->order)->get();
            } else {
                if ($request->order == 'asc')
                    $inbox_documents = User::find($this->logged_user->id)->inbox_documents_responsible->sortBy($request->sort);
                else
                    $inbox_documents = User::find($this->logged_user->id)->inbox_documents_responsible->sortByDesc($request->sort);
            }
        } else {
            if ($this->wall->hasPermission(['_superadmin'])) {
                $inbox_documents = InboxDocument::all();
            } else {
                $inbox_documents = User::find($this->logged_user->id)->inbox_documents_responsible;
            }
        }

        $count = count($inbox_documents);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($inbox_documents);
        $perPage = config('app_options.count_per_page');
        $currentPageSearchResults = $collection->slice((($currentPage - 1) * $perPage), $perPage)->all();
        $currentPageSearchResults = new LengthAwarePaginator($currentPageSearchResults, $count, $perPage);
        $inbox_documents = $currentPageSearchResults;
        $slice = ((($currentPage - 1) * $perPage) == 0) ? '1' : (($currentPage - 1) * $perPage);
        $perPage = (($currentPage * $perPage) > $count) ? $count : ($currentPage * $perPage);

        return view('documents.inbox', compact(
          'inbox_documents',
          'slice',
          'perPage',
          'count')
        );
    }
   

   /*
    * Форма создания входящего документа
    */
   public function inboxCreate()
   {

   }

   /*
    * Созранение входящего документа
    */
   public function inboxSave()
   {

   }

   /*
    * Форма редактирования входящего документа
    */
   public function inboxEdit()
   {

   }

   /*
    * Удаление входящего документа
    */
   public function inboxDelete()
   {

   }

   /*
    * Форма просмотра входящего документа
    */
   public function inboxView()
   {

   }

   /*
    * Отмена создания входящего документа
    */
   public function inboxCancel()
   {

   }

   // ---------------------------------------------------
   // --------------  Исходящие документы ---------------
   // ---------------------------------------------------

   /*
   * Вывод страницы с исходящими документами
   */
   public function outbox(Request $request)
   {
      // Сохраняем строку параметров в сессии
      $request->session()->put('outboxDocumentsParamSort', Input::all());

      // Сортировка
      if ($request->has('sort') && $request->has('order')) {
          if ($this->wall->hasPermission(['_superadmin'])) {
              $outbox_documents = OutboxDocument::orderBy($request->sort, $request->order)->get();
          } else {
              if ($request->order == 'asc')
                  $outbox_documents = User::find($this->logged_user->id)->outbox_documents_responsible->sortBy($request->sort);
              else
                  $outbox_documents = User::find($this->logged_user->id)->outbox_documents_responsible->sortByDesc($request->sort);
          }
      } else {
          if ($this->wall->hasPermission(['_superadmin'])) {
              $outbox_documents = OutboxDocument::all();
          } else {
              $outbox_documents = User::find($this->logged_user->id)->outbox_documents_responsible;
          }
      }

      $count = count($outbox_documents);

      $currentPage = LengthAwarePaginator::resolveCurrentPage();

      $collection = new Collection($outbox_documents);

      $perPage = config('app_options.count_per_page');

      $currentPageSearchResults = $collection->slice((($currentPage - 1) * $perPage), $perPage)->all();

      $currentPageSearchResults = new LengthAwarePaginator($currentPageSearchResults, $count, $perPage);

      $outbox_documents = $currentPageSearchResults;

      $slice = ((($currentPage - 1) * $perPage) == 0) ? '1' : (($currentPage - 1) * $perPage);
      $perPage = (($currentPage * $perPage) > $count) ? $count : ($currentPage * $perPage);

      return view('documents.outbox', compact(
        'outbox_documents',
        'slice',
        'perPage',
        'count')
      );





        
   }

   /*
    * Форма создания исходящего документа
    */
   public function outboxCreate()
   {

   }

   /*
    * Созранение исходящего документа
    */
   public function outboxSave()
   {

   }

   /*
    * Форма редактирования исходящего документа
    */
   public function outboxEdit()
   {

   }

   /*
    * Удаление исходящего документа
    */
   public function outboxDelete()
   {

   }

   /*
    * Форма просмотра исходящего документа
    */
   public function outboxView()
   {

   }

   /*
    * Отмена создания исходящего документа
    */
   public function outboxCancel()
   {

   }
}
