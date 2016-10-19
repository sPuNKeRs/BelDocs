<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use InitialPreview;

use App\InboxDocument;
use App\OutboxDocument;
use App\ItemNumber;
use App\Recipient;
use App\Http\Requests\InboxDocumentRequest;
use App\Http\Requests\OutboxDocumentRequest;


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
        if($this->wall->hasPermission(['_superadmin']))
        {
            $inbox_documents = InboxDocument::where('status', null)->orderBy('execute_date')->get();
            $outbox_documents = OutboxDocument::where('status', null)->orderBy('execute_date')->get();
        } 
        else
        {
            $inbox_documents = User::find($this->logged_user->id)->inbox_documents_responsible->where('status', null)->sortBy('execute_date');
            $outbox_documents = User::find($this->logged_user->id)->outbox_documents_responsible->where('status', null)->sortBy('execute_date');
        }       
        
        return view('documents.index', compact(
            'inbox_documents',
            'outbox_documents'
        ));
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
    $slug = uniqid();
    $entity_type = 'App\InboxDocument';

    if(count(InboxDocument::all()) > 0)
      $last_inbox_document_num = InboxDocument::orderBy('doc_num', 'DESC')->first()->doc_num;
    else
      $last_inbox_document_num = 0;

    // Создаем черновик
    $inbox_document = new InboxDocument(array(
        'doc_num' => $last_inbox_document_num + 1,
        'author_id' => $this->logged_user->id,
        'create_date' => date('d.m.Y'),
        'execute_date' => date('d.m.Y'),
        'slug' => $slug,
        'draft' => true
    ));

    $inbox_document->save();
    $id = $inbox_document->id;
    $draft = $inbox_document->draft;
    $entity = $inbox_document;

    $item_numbers_opt = ItemNumber::getArray();

    return view('documents.inbox-create', compact(
        'last_inbox_document_num',
        'item_numbers_opt',
        'id',
        'draft',
        'slug',
        'entity_type',
        'entity')
    );
   }

   /*
    * Созранение входящего документа
    */
   public function inboxSave(InboxDocumentRequest $request)
   {
      if ($request->id > 0) {
        $inbox_document = InboxDocument::find($request->id);
        $input = $request->all();
        $inbox_document->draft = false;

        $inbox_document->status = (isset($input->status)) ? $input->status : null;

        $inbox_document->update($input);

        return response(['status' => true, 'action' => 'update']);
      }

      return response(['status' => true, 
                       'action' => 'save', 
                       'id' => $inbox_document->id, 
                       'slug' => $inbox_document->slug]);
   }

   /*
    * Форма редактирования входящего документа
    */
   public function inboxEdit($id)
   {
      $entity_type = 'App\InboxDocument';
      $inbox_document = InboxDocument::findOrFail($id);       

      $comments = InboxDocument::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $inbox_document->id;
      $item_numbers_opt = ItemNumber::getArray();

      // FILES
      if (count($inbox_document->attachments) > 0) {
          $attachments = $inbox_document->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'inbox_documents');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $inbox_document;

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('documents.inbox-edit', compact(
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
    * Удаление входящего документа
    */
   public function inboxDelete($id, Request $request)
   {
      $inbox_document = InboxDocument::findOrFail($id);

      //Удаляем комментарии
      $comments = $inbox_document->comments;

      foreach ($comments as $comment) {
          $comment->delete();
      }

      // Удаляем вложения
      $attachments = $inbox_document->attachments;

      foreach ($attachments as $attachment) {
          $attachment->delete();
      }

      Storage::deleteDirectory('inbox_documents/' . $inbox_document->id);

      $inbox_document->delete();

      Session::flash('flash_message', 'Входящий документ успешно удален.');

      return redirect()->route('documents.inbox', $request->session()->get('inboxDocumentsParamSort'));
   }

   /*
    * Форма просмотра входящего документа
    */
   public function inboxView($id)
   {
      $entity_type = 'App\InboxDocument';
      $inbox_document = InboxDocument::findOrFail($id);
      $comments = InboxDocument::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $inbox_document->slug;       

      // FILES
      if (count($inbox_document->attachments) > 0) {
          $attachments = $inbox_document->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'inbox_documents');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $inbox_document;

      $item_numbers_opt = ItemNumber::getArray();

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('documents.inbox-view', compact(
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
    * Отмена создания входящего документа
    */
   public function inboxCancel(Request $request)
   {
      $inbox_document = InboxDocument::findOrFail($request->id);

      if ($inbox_document->draft == '1') {
          //Удаляем комментарии
          $comments = $inbox_document->comments;

          foreach ($comments as $comment) {
              $comment->delete();
          }

          // Удаляем вложения
          $attachments = $inbox_document->attachments;

          foreach ($attachments as $attachment) {
              $attachment->delete();
          }

          Storage::deleteDirectory('inbox_documents/' . $inbox_document->id);
          $inbox_document->delete();

          return redirect()->route('documents.inbox', $request->session()->get('inboxDocumentsParamSort'));
      }
      return redirect()->route('documents.inbox', $request->session()->get('inboxDocumentsParamSort'));
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
    $slug = uniqid();
    $entity_type = 'App\OutboxDocument';

    if(count(OutboxDocument::all()) > 0)
      $last_outbox_document_num = OutboxDocument::orderBy('doc_num', 'DESC')->first()->doc_num;
    else
      $last_outbox_document_num = 0;

    // Создаем черновик
    $outbox_document = new OutboxDocument(array(
        'doc_num' => $last_outbox_document_num + 1,
        'author_id' => $this->logged_user->id,
        'create_date' => date('d.m.Y'),
        'execute_date' => date('d.m.Y'),
        'slug' => $slug,
        'draft' => true
    ));

    $outbox_document->save();
    $id = $outbox_document->id;
    $draft = $outbox_document->draft;
    $entity = $outbox_document;

    $item_numbers_opt = ItemNumber::getArray();

    $recipients_opt = Recipient::getArray();

    return view('documents.outbox-create', compact(
        'last_outbox_document_num',
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
    * Созранение исходящего документа
    */
   public function outboxSave(OutboxDocumentRequest $request)
   {
    if ($request->id > 0) {
        $outbox_document = OutboxDocument::find($request->id);
        $input = $request->all();
        $outbox_document->draft = false;

        $outbox_document->status = (isset($input->status)) ? $input->status : null;

        $outbox_document->update($input);

        return response(['status' => true, 'action' => 'update']);
      }

      return response(['status' => true, 
                       'action' => 'save', 
                       'id' => $outbox_document->id, 
                       'slug' => $outbox_document->slug]);
   }

   /*
    * Форма редактирования исходящего документа
    */
   public function outboxEdit($id)
   {
      $entity_type = 'App\OutboxDocument';
      $outbox_document = OutboxDocument::findOrFail($id);       

      $comments = OutboxDocument::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $outbox_document->id;
      $item_numbers_opt = ItemNumber::getArray();
      $recipients_opt = Recipient::getArray();


      // FILES
      if (count($outbox_document->attachments) > 0) {
          $attachments = $outbox_document->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'outbox_documents');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $outbox_document;

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('documents.outbox-edit', compact(
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
    * Удаление исходящего документа
    */
   public function outboxDelete($id, Request $request)
   {
    $outbox_document = OutboxDocument::findOrFail($id);

      //Удаляем комментарии
      $comments = $outbox_document->comments;

      foreach ($comments as $comment) {
          $comment->delete();
      }

      // Удаляем вложения
      $attachments = $outbox_document->attachments;

      foreach ($attachments as $attachment) {
          $attachment->delete();
      }

      Storage::deleteDirectory('outbox_documents/' . $outbox_document->id);

      $outbox_document->delete();

      Session::flash('flash_message', 'Исходящий документ успешно удален.');

      return redirect()->route('documents.outbox', $request->session()->get('outboxDocumentsParamSort'));

   }

   /*
    * Форма просмотра исходящего документа
    */
   public function outboxView($id)
   {
      $entity_type = 'App\OutboxDocument';
      $outbox_document = OutboxDocument::findOrFail($id);
      $comments = OutboxDocument::find($id)->comments()->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
          $comment->user = $comment->user;
          $comment->user_profile = \App::make('authenticator')->getUserById($comment->user->id)->user_profile()->first();
      }

      $entity_id = $outbox_document->slug;       

      // FILES
      if (count($outbox_document->attachments) > 0) {
          $attachments = $outbox_document->attachments;
          $initialPreview = InitialPreview::getInitialPreview($attachments, 'outbox_documents');
          $initialPreviewConfig = json_encode(InitialPreview::getinitialPreviewConfig($attachments));
      }
      $append = true;

      $entity = $outbox_document;

      $item_numbers_opt = ItemNumber::getArray();
      $recipients_opt = Recipient::getArray();

      // Получить всех ответственных
      $responsibles = $entity->responsibles;

      return view('documents.outbox-view', compact(
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
    * Отмена создания исходящего документа
    */
   public function outboxCancel(Request $request)
   {
      $outbox_document = OutboxDocument::findOrFail($request->id);

      if ($outbox_document->draft == '1') {
          //Удаляем комментарии
          $comments = $outbox_document->comments;

          foreach ($comments as $comment) {
              $comment->delete();
          }

          // Удаляем вложения
          $attachments = $outbox_document->attachments;

          foreach ($attachments as $attachment) {
              $attachment->delete();
          }

          Storage::deleteDirectory('outbox_documents/' . $outbox_document->id);
          $outbox_document->delete();

          return redirect()->route('documents.outbox', $request->session()->get('outboxDocumentsParamSort'));
      }
      return redirect()->route('documents.outbox', $request->session()->get('outboxDocumentsParamSort'));
   }
}
