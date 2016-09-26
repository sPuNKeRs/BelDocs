<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemNumber extends Model
{
    protected $fillable = ['item_number', 'description'];

    // Получить справочник в ввиде массива
    // array('L' => 'Large', 'S' => 'Small')
    public static function getArray()
    {
        $item_numbers = ItemNumber::orderBy('id','ASC')->get();
        $options = array();

        foreach ($item_numbers as $item_number) {
            $options[$item_number->id] = $item_number->item_number;
        }

        return $options;
    }
}
