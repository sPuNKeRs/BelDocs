<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = ['title', 'type', 'size', 'path', 'url','entity_id', 'entity_type','author_id'];
    protected $dates = ['created_at', 'updated_at'];
    
    public function Entity()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}
