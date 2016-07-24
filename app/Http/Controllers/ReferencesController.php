<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ItemNumber;

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
        $this->item_numbers = ItemNumber::all();


        return view('admin.references.item_numbers.index')->with([
            'sidebar_items' => $this->getSidebar(),
            'item_numbers' => $this->item_numbers]);
    }

    // Справочник "Номенклатурный номер" - форма создания
    public function itemNumbersEdit(Request $request)
    {
        $item_number = ItemNumber::find($request->id);
        if(!$item_number)
        {
            $item_number = new ItemNumber();
        }
        
        return view('admin.references.item_numbers.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'item_number' => $item_number]);
    }

    // Справочник "Номенклатурный номер" - создание / редактирование
    public function itemNumbersPost(Request $request)
    {
        $id = $request->get('id');

        $item_number = ItemNumber::find($id);
        if(!$item_number)
        {
            $item_number = new ItemNumber($request->all());
            $item_number->save();
            $status = "Успешно создан";
        }
        else{
            $item_number->update($request->all());
            $status = "Успешно изменен";
        }
        return redirect()->route('references.itemnumber')->with('status', $status);
    }

    // Справочник "Номенклатурный номер" - удаление
    public function itemNumberDelete(Request $request)
    {
        if(ItemNumber::destroy($request->get('id')))
        {
            $status = "Успешно удален!";
        }else
        {
            $status = "Ошибка при удалени!";
        }

        return redirect()->route('references.itemnumber')->with('status', $status);
    }
    
    
    
    
    









    // Раздел справочника "Получатели"
    public function recipientsIndex()
    {
        return view('admin.references.recipients.index')->with(['sidebar_items' => $this->getSidebar()]);
    }
}
