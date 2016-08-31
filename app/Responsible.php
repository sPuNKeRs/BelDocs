<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    protected $fillable = ['entity_id', 'entity_type', 'user_id', 'executed_at', 'status'];

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


    public function setStatusAttribute($status)
    {
        if($status == 'false')
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }

        $this->attributes['status'] = $status;
    }

    public function setExecutedAtAttribute($date)
    {
        $this->attributes['executed_at'] = Carbon::createFromFormat('d.m.Y',$date);
    }
}
