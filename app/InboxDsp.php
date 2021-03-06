<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class InboxDsp extends Model
{
  use Eloquence;

  protected $searchableColumns = [
        'entity_num',
        'incoming_number',
        'item_number.item_number',
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

    // Заполняемые поля
    protected $fillable = [
        'dsp_num',
        'entity_num',
        'item_number_id',
        'incoming_number',
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
