<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $table = 'orders';

    protected $guarded = ['id'];

    protected $dates = ['create_date', 'execute_date', 'created_at', 'updated_at'];
}
