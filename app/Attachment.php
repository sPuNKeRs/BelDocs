<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = ['title', 'type', 'size', 'path','entity_id', 'author_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function orders()
    {
        return $this->belongsTo('App\Order','entity_id','slug');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}
