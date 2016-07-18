<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReferencesController extends Controller
{
    // "Номенклатурные номер"
    protected $item_numbers;

    // Констурктор класса
    public function __construct()
    {
        $this->item_numbers = "";
    }

    // Формирование бокового меню "Справочники"
    public function getSidebar()
    {
        return [
        "Номенклатурный номер" => [
            'url'  => route('references.itemnumber'),
            "icon" => '<i class="fa fa-list-ul"></i>'
        ],
        "Получатели"   => [
            'url'  => route('references.recipients'),
            "icon" => '<i class="fa fa-list-ul"></i>'
        ]
        ];
    }

    public function index()
    {
        return view('admin.references.index')->with(['sidebar_items' => $this->getSidebar()]);
    }




    // Раздел справочника "Номенклатурный номер"
    public function itemNumbersIndex()
    {
        return view('admin.references.item_numbers.index')->with([
            'sidebar_items' => $this->getSidebar(),
            'item_numbers' => $this->item_numbers]);
    }

    // Справочник "Номенклатурный номер" - форма создания
    public function itemNumbersEdit()
    {
        
        
        return view('admin.references.item_numbers.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'item_numbers' => $this->item_numbers]);
    }

    // Справочник "Номенклатурный номер" - сохранение
    public function itemNumbersStore()
    {

    }









    // Раздел справочника "Получатели"
    public function recipientsIndex()
    {
        return view('admin.references.recipients.index')->with(['sidebar_items' => $this->getSidebar()]);
    }
}
