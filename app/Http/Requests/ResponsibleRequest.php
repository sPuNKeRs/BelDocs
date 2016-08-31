<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResponsibleRequest extends Request
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
            'entity_id' => 'required',
            'entity_type' => 'required',
            'user_id' => 'required',
            'executed_at' => 'required',
            'status' => 'required',
        ];
    }
}
