<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Sofa\Eloquence\Eloquence;

class OutboxOrder extends Model
{
   use Eloquence;

   protected $searchableColumns = [
        'entity_num',
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

  // Заполняемые поля
    protected $fillable = [
      'outbox_order_num',
      'entity_num',
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
