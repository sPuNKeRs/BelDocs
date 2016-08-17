<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    public function Entity()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'entity_id');
    }
}
