<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['entity_id', 'author_id', 'content'];

    public function orders()
    {
        return $this->belongsTo('App\Order','entity_id','slug');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}
