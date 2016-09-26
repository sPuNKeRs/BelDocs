<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function responsibles()
    {
        return $this->morphMany('App\Responsible', 'entity');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'entity');
    }

    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'entity');
    }

    public function sender()
    {
        return $this->hasOne('App\Sender', 'id', 'sender_id');
    }

    public function item_number()
    {
        return $this->hasOne('App\ItemNumber', 'id', 'item_number_id');
    }



    // Заполняемые поля
    protected $fillable = ['order_num',
        'item_number_id',
        'incoming_number',
        'sender_id',
        'title',
        'create_date',
        'execute_date',
        'description',
        'resolution',
        'status',
        'author_id',
        'slug',
        'draft'];


    public function setCreateDateAttribute($date)
    {
        $this->attributes['create_date'] = Carbon::createFromFormat('d.m.Y', $date);
    }

    public function setExecuteDateAttribute($date)
    {
        $this->attributes['execute_date'] = Carbon::createFromFormat('d.m.Y', $date);
    }
}
