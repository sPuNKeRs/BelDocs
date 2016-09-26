<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemNumberDsp extends Model
{
    protected $fillable = ['item_number_dsp', 'description'];

    // Получить справочник в ввиде массива
    // array('L' => 'Large', 'S' => 'Small')
    public static function getArray()
    {
        $item_numbers_dsp = ItemNumberDsp::orderBy('id','ASC')->get();
        $options = array();

        foreach ($item_numbers_dsp as $item_number_dsp) {
            $options[$item_number_dsp->item_number_dsp] = $item_number_dsp->item_number_dsp;
        }

        return $options;
    }
}
