<?php

namespace App;

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

    
}
