<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipientDsp extends Model
{
    protected $fillable = ['recipient_dsp', 'description'];

    // Получить справочник в ввиде массива
    // array('L' => 'Large', 'S' => 'Small')
    public static function getArray()
    {
        $recipients_dsp = RecipientDsp::orderBy('id','ASC')->get();
        $options = array();

        foreach ($recipients_dsp as $recipient_dsp) {
            $options[$recipient_dsp->recipient_dsp] = $recipient_dsp->recipient_dsp;
        }

        return $options;
    }
}
