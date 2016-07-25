<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


    // Заполняемые поля
    protected $fillable = ['item_number',
                           'incoming_number',
                           'title',
                           'create_date',
                           'execute_date',
                           'description',
                           'status',
                           'slug'];

//    protected $dates = ['create_date',
//                        'execute_date',];

    public function setCreateDateAttribute($date)
    {
        $this->attributes['create_date'] = Carbon::createFromFormat('d.m.Y',$date);
    }

    public function setExecuteDateAttribute($date)
    {
        $this->attributes['execute_date'] = Carbon::createFromFormat('d.m.Y',$date);
    }

    
}