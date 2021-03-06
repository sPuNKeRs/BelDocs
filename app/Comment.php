<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['entity_id', 'entity_type', 'author_id', 'content'];
    protected $dates = ['created_at', 'updated_at'];


    public function Entity()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }

    function setCreatedAtAttribute($date) {
        $this->attributes['created_at'] = new Carbon($date);
    }

    function setUpdatedAtAttribute($date) {
        $this->attributes['updated_at'] = new Carbon($date);
    }
}
