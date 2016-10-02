<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

class DocumentsController extends Controller
{
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
   public function inbox()
   {
        return view('documents.inbox');
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
   public function outbox()
   {
        return view('documents.outbox');
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
