<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class OutboxDsp extends Model
{
    use Eloquence;

    protected $searchableColumns = [
        'entity_num',
        'incoming_number',
        'item_number.item_number',
        'recipient.recipient',
        'title',
        'description',
        'resolution'
    ];

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

    public function item_number()
    {
        return $this->hasOne('App\ItemNumberDsp', 'id', 'item_number_id');
    }

     public function recipient()
    {
        return $this->hasOne('App\Recipient', 'id', 'recipient_id');
    }

    // Заполняемые поля
    protected $fillable = [
        'dsp_num',
        'entity_num',
        'item_number_id',
        'recipient_id',
        'title',
        'create_date',
        'execute_date',
        'description',
        'resolution',
        'status',
        'author_id',
        'slug',
        'draft'
    ];

    public function setCreateDateAttribute($date)
    {
        $this->attributes['create_date'] = Carbon::createFromFormat('d.m.Y', $date);
    }

    public function setExecuteDateAttribute($date)
    {
        $this->attributes['execute_date'] = Carbon::createFromFormat('d.m.Y', $date);
    }
}
