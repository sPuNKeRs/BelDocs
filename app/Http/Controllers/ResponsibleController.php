<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ResponsibleRequest;
use App\Responsible;
use App\Order;
use App\User;


class ResponsibleController extends Controller
{    
    public function index()
    {

    }

    public function store(ResponsibleRequest $request)
    {
        if($request->rel_id){
            $responsible = Responsible::find($request->rel_id);
            $responsible->update($request->all());
            return response([$responsible, 'id'=>$responsible->id]);
        }
        else{
            $responsible = Responsible::create($request->all());
            return response([$request->all(), 'id'=>$responsible->id]);
        }
    }

    public function destroy(Request $request)
    {
        if(Responsible::destroy($request->id))
        {
            return response($request->id);
        }
            return response('Ошибка при удалении ответсвенного!', 401);
    }
    
    public function getResponsibleTpl(Request $request)
    {
        return view('partials.responsibles_li', ['countLi' => $request->countLi]);
    }
}
