<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OutboxDspRequest extends Request
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
            'entity_num' => 'required',            
            'title' => 'required',
            'create_date' => 'required',
            'execute_date' => 'required',
            //'description' => 'max:1500',            
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
            'entity_num.required' => 'Поле номер ДСП обязательно для заполнения',            
            'title.required' => 'Поле тема обязательно для заполения',
            'create_date.required' => 'Поле дата создания обязательно для заполнения',
            'execute_date.required' => 'Поле дата исполнения обязательно для заполнения'
        ];
    }
}
