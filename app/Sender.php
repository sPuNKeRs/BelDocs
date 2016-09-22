<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
  protected $fillable = ['sender', 'description'];

    // Получить справочник в ввиде массива
    // array('L' => 'Large', 'S' => 'Small')
    public static function getArray()
    {
        $senders = Sender::orderBy('id','ASC')->get();
        $options = array();

        foreach ($senders as $sender) {
            $options[$sender->id] = $sender->sender;
        }

        return $options;
    }
}
