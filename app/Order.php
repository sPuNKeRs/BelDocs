<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function comments()
    {
        return $this->hasMany('App\Comment','entity_id','slug');
    }

    public function attachments()
    {
        return $this->hasMany('App\Attachment', 'entity_id', 'slug');
    }


    // Заполняемые поля
    protected $fillable = ['order_num',
                           'item_number',
                           'incoming_number',
                           'title',
                           'create_date',
                           'execute_date',
                           'description',
                           'resolution',
                           'status',
                           'author_id',
                           'slug',
                           'draft'];

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
