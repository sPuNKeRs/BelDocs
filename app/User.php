<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment','author_id','id');
    }

    public function responsibles()
    {
        return $this->hasMany('App\Responsible', 'user_id', 'id');
    }

    public function orders_responsible()
    {
        return $this->belongsToMany('App\Order', 'responsibles', 'user_id', 'entity_id')->where('entity_type', '=', 'App\Order');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'author_id', 'id');
    }
    
    public static function getArrayOptions()
    {
        $users = User::all();
        $options = [];

        foreach ($users as $user)
        {
            $user_profile = $user_profile = \App::make('authenticator')->getUserById($user->id)->user_profile()->first();
            $options[$user->id] = $user_profile->last_name." ".$user_profile->first_name." ".$user_profile->second_name;
        }

        return $options;
    }

}
