<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\ItemNumber;
use App\Recipient;
use App\Sender;
use App\Declarer;

class ReferencesController extends Controller
{
    // "Номенклатурные номер"
    protected $item_numbers;
    // "Получатели"
    protected $recipients;
    // "Отправители"
    protected $senders;
    // "Заявители"
    protected $declarers;

    // Констурктор класса
    public function __construct()
    {
        $this->item_numbers = "";
        $this->recipients = "";
        $this->senders = "";
        $this->declarers = "";
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
            'url'  => route('references.recipient'),
            "icon" => '<i class="fa fa-list-ul"></i>'
        ], 
        "Отправители"   => [
            'url'  => route('references.sender'),
            "icon" => '<i class="fa fa-list-ul"></i>'
        ],         
        "Заявители"   => [
            'url'  => route('references.declarer'),
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
        $this->recipients = Recipient::all();

        return view('admin.references.recipients.index')->with([
            'sidebar_items' => $this->getSidebar(), 
            'recipients' => $this->recipients]);
    }

    // Справочник "Получатели" - Сохранение
    public function recipientPost(Request $request)
    {
        $id = $request->get('id');

        $recipient = Recipient::find($id);
        if(!$recipient)
        {
            $recipient = new Recipient($request->all());
            $recipient->save();
            $status = "Успешно создан";
        }
        else{
            $recipient->update($request->all());
            $status = "Успешно изменен";
        }
        return redirect()->route('references.recipient')->with('status', $status);

    }
    
    // Справочник "Получатели" - Редактирование 
    public function recipientEdit(Request $request)
    {
        $recipient = Recipient::find($request->id);
        if(!$recipient)
        {
            $recipient = new Recipient();
        }
        
        return view('admin.references.recipients.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'recipient' => $recipient]);

    }

    // Справочник "Получатели" - Удаление
    public function recipientDelete(Request $request)
    {
        if(Recipient::destroy($request->get('id')))
        {
            $status = "Успешно удален!";
        }
        else
        {
            $status = "Ошибка при удалени!";
        }

        return redirect()->route('references.recipient')->with('status', $status);
    }

    // Раздел справочника "Получатели"
    public function sendersIndex()
    {
        $this->senders = Sender::all();

        return view('admin.references.senders.index')->with([
            'sidebar_items' => $this->getSidebar(), 
            'senders' => $this->senders
        ]);
    }

    // Раздел справочника "Получатели" - Сохранение
    public function senderPost(Request $request)
    {
        $id = $request->get('id');

        $sender = Sender::find($id);
        if(!$sender)
        {
            $sender = new Sender($request->all());
            $sender->save();
            $status = "Успешно создан";
        }
        else{
            $sender->update($request->all());
            $status = "Успешно изменен";
        }
        return redirect()->route('references.sender')->with('status', $status);

    }

    // Раздел справочника "Получатели" - Редактирование
    public function senderEdit(Request $request)
    {
        $sender = Sender::find($request->id);
        if(!$sender)
        {
            $sender = new Sender();
        }
        
        return view('admin.references.senders.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'sender' => $sender]);

    }

    // Раздел справочника "Получатели" - Удаление
    public function senderDelete(Request $request)
    {
        if(Sender::destroy($request->get('id')))
        {
            $status = "Успешно удален!";
        }
        else
        {
            $status = "Ошибка при удалени!";
        }

        return redirect()->route('references.sender')->with('status', $status);
    }

    // Раздел справочника "Заявитель"
    public function declarersIndex()
    {
        $this->declarers = Declarer::all();

        return view('admin.references.declarers.index')->with([
            'sidebar_items' => $this->getSidebar(), 
            'declarers' => $this->declarers
        ]);

    }

    // Раздел справочника "Заявитель" - Сохранение
    public function declarerPost(Request $request)
    {
        $id = $request->get('id');

        $declarer = Declarer::find($id);
        if(!$declarer)
        {
            $declarer = new Declarer($request->all());
            $declarer->save();
            $status = "Успешно создан";
        }
        else{
            $declarer->update($request->all());
            $status = "Успешно изменен";
        }
        return redirect()->route('references.declarer')->with('status', $status);

    }

    // Раздел справочника "Заявитель" - Редактирование
    public function declarerEdit(Request $request)
    {
        $declarer = Declarer::find($request->id);
        if(!$declarer)
        {
            $declarer = new Sender();
        }
        
        return view('admin.references.declarers.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'declarer' => $declarer]);

    }

    // Раздел справочника "Заявитель" - Удаление
    public function declarerDelete(Request $request)
    {
        if(Declarer::destroy($request->get('id')))
        {
            $status = "Успешно удален!";
        }
        else
        {
            $status = "Ошибка при удалени!";
        }

        return redirect()->route('references.declarer')->with('status', $status);

    }
}
