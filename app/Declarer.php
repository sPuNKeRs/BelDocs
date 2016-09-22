<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Declarer extends Model
{
  protected $fillable = ['declarer', 'description'];

    // Получить справочник в ввиде массива
    // array('L' => 'Large', 'S' => 'Small')
    public static function getArray()
    {
        $declarers = Declarer::orderBy('id','ASC')->get();
        $options = array();

        foreach ($declarers as $declarer) {
            $options[$declarer->declarer] = $declarer->declarer;
        }

        return $options;
    }
}
