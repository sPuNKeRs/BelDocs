<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use Sortable;

    protected $sortable = ['order_num', 'item_number', 'incoming_number', 'title', 'create_date', 'execute_date', 'status'];

    

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


    public function setCreateDateAttribute($date)
    {
        $this->attributes['create_date'] = Carbon::createFromFormat('d.m.Y',$date);
    }

    public function setExecuteDateAttribute($date)
    {
        $this->attributes['execute_date'] = Carbon::createFromFormat('d.m.Y',$date);
    }
}
