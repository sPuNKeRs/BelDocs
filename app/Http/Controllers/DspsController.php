<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use InitialPreview;


use App\Http\Requests;
use App\Http\Requests\InboxDspRequest;
use App\Http\Requests\OutboxDspRequest;

use App\InboxDsp;
use App\OutboxDsp;
use App\ItemNumberDsp;

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
    $request->session()->put('inboxDspParamSort', Input::all());

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
        $slug = uniqid();
        $entity_type = 'App\InboxDsp';

        if(count(InboxDsp::all()) > 0)
            $last_inbox_dsp_num = InboxDsp::orderBy('dsp_num', 'DESC')->first()->dsp_num;
        else
            $last_inbox_dsp_num = 0;

        // Создаем черновик
        $inbox_dsp = new InboxDsp(array(
            'dsp_num' => $last_inbox_dsp_num + 1,
            'author_id' => $this->logged_user->id,
            'create_date' => date('d.m.Y'),
            'execute_date' => date('d.m.Y'),
            'slug' => $slug,
            'draft' => true
        ));

        $inbox_dsp->save();
        $id = $inbox_dsp->id;
        $draft = $inbox_dsp->draft;
        $entity = $inbox_dsp;

        $item_numbers_opt = ItemNumberDsp::getArray();

        return view('dsp.inbox-create', compact(
            'last_inbox_dsp_num',
            'item_numbers_opt',
            'id',
            'draft',
            'slug',
            'entity_type',
            'entity')
        );
   }

   /*
    * Созранение входящего ДСП
    */
   public function inboxSave(InboxDspRequest $request)
   {
       if ($request->id > 0) {
        $inbox_dsp = InboxDsp::find($request->id);
        $input = $request->all();
        $inbox_dsp->draft = false;

        $inbox_dsp->status = (isset($input->status)) ? $input->status : null;

        $inbox_dsp->update($input);

        return response(['status' => true, 'action' => 'update']);
      }

      return response(['status' => true, 
                       'action' => 'save', 
                       'id' => $inbox_dsp->id, 
                       'slug' => $inbox_dsp->slug]);
   }

   /*
    * Форма редактирования входящего ДСП
    */
   public function inboxEdit($id)
   {       
      $entity_type = 'App\InboxDsp';
      $inbox_dsp = InboxDsp::findOrFail($id);       

      $comments = InboxDsp::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $inbox_dsp->id;
      $item_numbers_opt = ItemNumberDsp::getArray();

      // FILES
      if (count($inbox_dsp->attachments) > 0) {
          $attachments = $inbox_dsp->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'inbox_dsps');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $inbox_dsp;

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('dsp.inbox-edit', compact(
          'entity',
          'item_numbers_opt',
          'senders_opt',
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
    * Удаление входящего ДСП
    */
   public function inboxDelete($id, Request $request)
   {
      $inbox_dsp = InboxDsp::findOrFail($id);

      //Удаляем комментарии
      $comments = $inbox_dsp->comments;

      foreach ($comments as $comment) {
          $comment->delete();
      }

      // Удаляем вложения
      $attachments = $inbox_dsp->attachments;

      foreach ($attachments as $attachment) {
          $attachment->delete();
      }

      Storage::deleteDirectory('inbox_dsps/' . $inbox_dsp->id);

      $inbox_dsp->delete();

      Session::flash('flash_message', 'Входящий ДСП успешно удален.');

      return redirect()->route('dsp.inbox', $request->session()->get('inboxDspParamSort'));

   }

   /*
    * Форма просмотра входящего ДСП
    */
   public function inboxView($id)
   {
      $entity_type = 'App\InboxDsp';
      $inbox_dsp = InboxDsp::findOrFail($id);
      $comments = InboxDsp::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $inbox_dsp->slug;       

      // FILES
      if (count($inbox_dsp->attachments) > 0) {
          $attachments = $inbox_dsp->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'inbox_dsps');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $inbox_dsp;

      $item_numbers_opt = ItemNumberDsp::getArray();

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('dsp.inbox-view', compact(
          'entity',
          'entity_id',
          'item_numbers_opt',
          'comments',
          'initialPreview',
          'initialPreviewConfig',
          'append',
          'entity_type',
          'responsibles')
      );
   }

   /*
    * Отмена создания входящего ДСП
    */
   public function inboxCancel(Request $request)
   {
      $inbox_dsp = InboxDsp::findOrFail($request->id);

      if ($inbox_dsp->draft == '1') {
          //Удаляем комментарии
          $comments = $inbox_dsp->comments;

          foreach ($comments as $comment) {
              $comment->delete();
          }

          // Удаляем вложения
          $attachments = $inbox_dsp->attachments;

          foreach ($attachments as $attachment) {
              $attachment->delete();
          }

          Storage::deleteDirectory('inbox_dsps/' . $inbox_dsp->id);
          $inbox_dsp->delete();

          return redirect()->route('dsp.inbox', $request->session()->get('inboxDspParamSort'));
      }
      return redirect()->route('dsp.inbox', $request->session()->get('inboxDspParamSort'));
   }
   // ---------------------------------------------------
   // ----------------  Исходящие ДСП -------------------
   // ---------------------------------------------------

   /*
   * Вывод страницы с исходящими ДСП
   */
   public function outbox(Request $request)
   {
      // Сохраняем строку параметров в сессии
      $request->session()->put('outboxDspParamSort', Input::all());

      // Сортировка
      if ($request->has('sort') && $request->has('order')) {
          if ($this->wall->hasPermission(['_superadmin'])) {
              $outbox_dsps = OutboxDsp::orderBy($request->sort, $request->order)->get();
          } else {
              if ($request->order == 'asc')
                  $outbox_dsps = User::find($this->logged_user->id)->outbox_dsps_responsible->sortBy($request->sort);
              else
                  $outbox_dsps = User::find($this->logged_user->id)->outbox_dsps_responsible->sortByDesc($request->sort);
          }
      } else {
          if ($this->wall->hasPermission(['_superadmin'])) {
              $outbox_dsps = OutboxDsp::all();
          } else {
              $outbox_dsps = User::find($this->logged_user->id)->outbox_dsps_responsible;
          }
      }

      $count = count($outbox_dsps);

      $currentPage = LengthAwarePaginator::resolveCurrentPage();

      $collection = new Collection($outbox_dsps);

      $perPage = config('app_options.count_per_page');

      $currentPageSearchResults = $collection->slice((($currentPage - 1) * $perPage), $perPage)->all();

      $currentPageSearchResults = new LengthAwarePaginator($currentPageSearchResults, $count, $perPage);

      $outbox_dsps = $currentPageSearchResults;

      $slice = ((($currentPage - 1) * $perPage) == 0) ? '1' : (($currentPage - 1) * $perPage);
      $perPage = (($currentPage * $perPage) > $count) ? $count : ($currentPage * $perPage);

      return view('dsp.outbox', compact(
        'outbox_dsps',
        'slice',
        'perPage',
        'count')
      );        
   }

   /*
    * Форма создания исходящего ДСП
    */
   public function outboxCreate()
   {
        $slug = uniqid();
        $entity_type = 'App\OutboxDsp';

        if(count(OutboxDsp::all()) > 0)
            $last_outbox_dsp_num = OutboxDsp::orderBy('dsp_num', 'DESC')->first()->dsp_num;
        else
            $last_outbox_dsp_num = 0;

        // Создаем черновик
        $outbox_dsp = new OutboxDsp(array(
            'dsp_num' => $last_outbox_dsp_num + 1,
            'author_id' => $this->logged_user->id,
            'create_date' => date('d.m.Y'),
            'execute_date' => date('d.m.Y'),
            'slug' => $slug,
            'draft' => true
        ));

        $outbox_dsp->save();
        $id = $outbox_dsp->id;
        $draft = $outbox_dsp->draft;
        $entity = $outbox_dsp;

        $item_numbers_opt = ItemNumberDsp::getArray();

        $recipients_opt = Recipient::getArray();

        return view('dsp.outbox-create', compact(
            'last_outbox_dsp_num',
            'item_numbers_opt',
            'recipients_opt',
            'id',
            'draft',
            'slug',
            'entity_type',
            'entity')
        );
   }

   /*
    * Созранение исходящего ДСП
    */
   public function outboxSave(OutboxDspRequest $request)
   {
       if ($request->id > 0) {
        $outbox_dsp = OutboxDsp::find($request->id);
        $input = $request->all();
        $outbox_dsp->draft = false;

        $outbox_dsp->status = (isset($input->status)) ? $input->status : null;

        $outbox_dsp->update($input);

        return response(['status' => true, 'action' => 'update']);
      }

      return response(['status' => true, 
                       'action' => 'save', 
                       'id' => $outbox_dsp->id, 
                       'slug' => $outbox_dsp->slug]);

   }

   /*
    * Форма редактирования исходящего ДСП
    */
   public function outboxEdit($id)
   {
      $entity_type = 'App\OutboxDsp';
      $outbox_dsp = OutboxDsp::findOrFail($id);       

      $comments = OutboxDsp::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $outbox_dsp->id;
      $item_numbers_opt = ItemNumberDsp::getArray();
      $recipients_opt = Recipient::getArray();


      // FILES
      if (count($outbox_dsp->attachments) > 0) {
          $attachments = $outbox_dsp->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'outbox_dsps');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $outbox_dsp;

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('dsp.outbox-edit', compact(
          'entity',
          'item_numbers_opt',
          'recipients_opt',
          'senders_opt',
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
    * Удаление исходящего ДСП
    */
   public function outboxDelete($id, Request $request)
   {
      $outbox_dsp = OutboxDsp::findOrFail($id);

      //Удаляем комментарии
      $comments = $outbox_dsp->comments;

      foreach ($comments as $comment) {
          $comment->delete();
      }

      // Удаляем вложения
      $attachments = $outbox_dsp->attachments;

      foreach ($attachments as $attachment) {
          $attachment->delete();
      }

      Storage::deleteDirectory('outbox_dsps/' . $outbox_dsp->id);

      $outbox_dsp->delete();

      Session::flash('flash_message', 'Исходящий ДСП успешно удален.');

      return redirect()->route('dsp.outbox', $request->session()->get('outboxDspParamSort'));

   }

   /*
    * Форма просмотра исходящего ДСП
    */
   public function outboxView($id)
   {
      $entity_type = 'App\OutboxDsp';
      $outbox_dsp = OutboxDsp::findOrFail($id);
      $comments = OutboxDsp::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $outbox_dsp->slug;       

      // FILES
      if (count($outbox_dsp->attachments) > 0) {
          $attachments = $outbox_dsp->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'outbox_dsps');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $outbox_dsp;

      $item_numbers_opt = ItemNumberDsp::getArray();
      $recipients_opt = Recipient::getArray();

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('dsp.outbox-view', compact(
          'entity',
          'entity_id',
          'item_numbers_opt',
          'recipients_opt',
          'comments',
          'initialPreview',
          'initialPreviewConfig',
          'append',
          'entity_type',
          'responsibles')
      );
   }

   /*
    * Отмена создания исходящего ДСП
    */
   public function outboxCancel(Request $request)
   {
      $outbox_dsp = OutboxDsp::findOrFail($request->id);

      if ($outbox_dsp->draft == '1') {
          //Удаляем комментарии
          $comments = $outbox_dsp->comments;

          foreach ($comments as $comment) {
              $comment->delete();
          }

          // Удаляем вложения
          $attachments = $outbox_dsp->attachments;

          foreach ($attachments as $attachment) {
              $attachment->delete();
          }

          Storage::deleteDirectory('outbox_dsps/' . $outbox_dsp->id);
          $outbox_dsp->delete();

          return redirect()->route('dsp.outbox', $request->session()->get('outboxDspParamSort'));
      }
      return redirect()->route('dsp.outbox', $request->session()->get('outboxDspParamSort'));

   }
}
