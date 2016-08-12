<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveOrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'order_id' => 'required',
            'item_number' => 'required',
            'incoming_number' => 'required',
            'title' => 'required',
            'create_date' => 'required',
            'execute_date' => 'required',
            'description' => 'max:500',
            
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'order_id.required' => 'Поле порядковый номер обязательно для заполнения',
            'item_number.required' => 'Поле номенклатурный номер обязательно для заполнения',
            'incoming_number.required' => 'Поле входящий номер обязательно для заполнения',
            'title.required' => 'Поле тема обязательно для заполения',
            'create_date.required' => 'Поле дата создания обязательно для заполнения',
            'execute_date.required' => 'Поле дата исполнения обязательно для заполнения'
        ];
    }
}
