<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\ItemNumber;
use App\ItemNumberDsp;
use App\Recipient;
use App\RecipientDsp;
use App\Sender;
use App\Declarer;

class ReferencesController extends Controller
{
    // "Номенклатурные номер"
    protected $item_numbers;
    // "Получатели"
    protected $recipients;
    // "Получатели"
    protected $recipients_dsp;
    // "Отправители"
    protected $senders;
    // "Заявители"
    protected $declarers;

    // Констурктор класса
    public function __construct()
    {
        $this->item_numbers = "";
        $this->recipients = "";
        $this->recipients_dsp = "";
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
         "Номенклатурный номер ДСП" => [
            'url'  => route('references.itemnumber_dsp'),
            "icon" => '<i class="fa fa-list-ul"></i>'
        ],
        "Получатели"   => [
            'url'  => route('references.recipient'),
            "icon" => '<i class="fa fa-list-ul"></i>'
        ], 
        "Получатели ДСП"   => [
            'url'  => route('references.recipient_dsp'),
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

    // Раздел справочника "Номенклатурный номер ДСП"
    public function itemNumbers_dspIndex()
    {
        $this->item_numbers_dsp= ItemNumberDsp::all();


        return view('admin.references.item_numbers_dsp.index')->with([
            'sidebar_items' => $this->getSidebar(),
            'item_numbers_dsp' => $this->item_numbers_dsp]);
    }

    // Справочник "Номенклатурный номер ДСП" - форма создания
    public function itemNumbers_dspEdit(Request $request)
    {
        $item_number_dsp = ItemNumberDsp::find($request->id);
        if(!$item_number_dsp)
        {
            $item_number_dsp = new ItemNumberDsp();
        }
        
        return view('admin.references.item_numbers_dsp.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'item_number_dsp' => $item_number_dsp]);
    }

    // Справочник "Номенклатурный номер ДСП" - создание / редактирование
    public function itemNumbers_dspPost(Request $request)
    {
        $id = $request->get('id');

        $item_number_dsp = ItemNumberDsp::find($id);
        if(!$item_number_dsp)
        {
            $item_number_dsp = new ItemNumberDsp($request->all());
            $item_number_dsp->save();
            $status = "Успешно создан";
        }
        else{
            $item_number_dsp->update($request->all());
            $status = "Успешно изменен";
        }
        return redirect()->route('references.itemnumber_dsp')->with('status', $status);
    }

    // Справочник "Номенклатурный номер ДСП" - удаление
    public function itemNumber_dspDelete(Request $request)
    {
        if(ItemNumberDsp::destroy($request->get('id')))
        {
            $status = "Успешно удален!";
        }else
        {
            $status = "Ошибка при удалени!";
        }

        return redirect()->route('references.itemnumber_dsp')->with('status', $status);
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

    // Раздел справочника "Получатели ДСП"
    public function recipient_dspIndex()
    {
        $this->recipients_dsp = RecipientDsp::all();

        return view('admin.references.recipients_dsp.index')->with([
            'sidebar_items' => $this->getSidebar(), 
            'recipients_dsp' => $this->recipients_dsp]);
    }

    // Справочник "Получатели ДСП" - Сохранение
    public function recipient_dspPost(Request $request)
    {
        $id = $request->get('id');

        $recipient_dsp = RecipientDsp::find($id);
        if(!$recipient_dsp)
        {
            $recipient_dsp = new RecipientDsp($request->all());
            $recipient_dsp->save();
            $status = "Успешно создан";
        }
        else{
            $recipient_dsp->update($request->all());
            $status = "Успешно изменен";
        }
        return redirect()->route('references.recipient_dsp')->with('status', $status);

    }
    
    // Справочник "Получатели ДСП" - Редактирование 
    public function recipient_dspEdit(Request $request)
    {
        $recipient_dsp = RecipientDsp::find($request->id);
        if(!$recipient_dsp)
        {
            $recipient_dsp = new RecipientDsp();
        }
        
        return view('admin.references.recipients_dsp.edit')->with([
            'sidebar_items' => $this->getSidebar(),
            'recipient_dsp' => $recipient_dsp]);

    }

    // Справочник "Получатели ДСП" - Удаление
    public function recipient_dspDelete(Request $request)
    {
        if(RecipientDsp::destroy($request->get('id')))
        {
            $status = "Успешно удален!";
        }
        else
        {
            $status = "Ошибка при удалени!";
        }

        return redirect()->route('references.recipient_dsp')->with('status', $status);
    }

    // Раздел справочника "Отправители"
    public function sendersIndex()
    {
        $this->senders = Sender::all();

        return view('admin.references.senders.index')->with([
            'sidebar_items' => $this->getSidebar(), 
            'senders' => $this->senders
        ]);
    }

    // Раздел справочника "Отправители" - Сохранение
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

    // Раздел справочника "Отправители" - Редактирование
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

    // Раздел справочника "Отправители" - Удаление
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
