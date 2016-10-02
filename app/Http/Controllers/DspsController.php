<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DspsController extends Controller
{
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
   public function inbox()
   {
        return view('dsp.inbox');
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
