<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
  protected $fillable = ['recipient', 'description'];

    // Получить справочник в ввиде массива
    // array('L' => 'Large', 'S' => 'Small')
    public static function getArray()
    {
        $recipients = Recipient::orderBy('id','ASC')->get();
        $options = array();

        foreach ($recipients as $recipient) {
            $options[$recipient->id] = $recipient->recipient;
        }

        return $options;
    }
}
