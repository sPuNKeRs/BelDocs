<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Responsible;

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

    // -------------------------------------------------
    // ------------------ Комментарии ------------------
    // -------------------------------------------------

    public function comments()
    {
        return $this->hasMany('App\Comment', 'author_id', 'id');
    }

    // -------------------------------------------------
    // ------------------ Ответственные ----------------
    // -------------------------------------------------
    public function responsibles()
    {
        return $this->hasMany('App\Responsible', 'user_id', 'id');
    }

    public function inbox_documents_responsible()
    {
        return $this->belongsToMany('App\InboxDocument', 'responsibles', 'user_id', 'entity_id')->where('entity_type', '=', 'App\InboxDocument');
    }

    public function outbox_documents_responsible()
    {
        return $this->belongsToMany('App\OutboxDocument', 'responsibles', 'user_id', 'entity_id')->where('entity_type', '=', 'App\OutboxDocument');
    }

    public function orders_responsible()
    {
        return $this->belongsToMany('App\Order', 'responsibles', 'user_id', 'entity_id')->where('entity_type', '=', 'App\Order');
    }

    public function outbox_orders_responsible()
    {
        return $this->belongsToMany('App\OutboxOrder', 'responsibles', 'user_id', 'entity_id')->where('entity_type', '=', 'App\OutboxOrder');
    }

    // -------------------------------------------------
    // ------------------- Приказы ---------------------
    // -------------------------------------------------

    public function orders()
    {
        return $this->hasMany('App\Order', 'author_id', 'id');
    }

    public function outbox_orders()
    {
        return $this->hasMany('App\OutboxOrder', 'author_id', 'id');
    }

    // -------------------------------------------------
    // ------------------ Документы --------------------
    // -------------------------------------------------
    
    public function inbox_documents()
    {
        return $this->hasMany('App\InboxDocument', 'author_id', 'id');
    }

    public function outbox_documents()
    {
        return $this->hasMany('App\OutboxDocument', 'author_id', 'id');
    }



    public static function getArrayOptions($entity_id = null, $entity_type = null)
    {
        $users = User::all();

        if ($entity_id && $entity_type) {
            $entity = $entity_type::find($entity_id);

            $responsibles = $entity->responsibles;

            $user_already = [];

            foreach ($responsibles as $responsible) {
                $user_already[] = $responsible->user_id;
            }

            foreach ($users as $key => $user) {
                if (in_array($user->id, $user_already)) {
                    array_forget($users, $key);
                }
            }
        }

        $options = [];

        foreach ($users as $user) {
            $user_profile = $user_profile = \App::make('authenticator')->getUserById($user->id)->user_profile()->first();
            $options[$user->id] = $user_profile->last_name . " " . $user_profile->first_name . " " . $user_profile->second_name;
        }

        return $options;
    }

    public static function getArrayUser($user_id)
    {
        $options = [];
        $user = User::find($user_id);

        $user_profile = $user_profile = \App::make('authenticator')->getUserById($user->id)->user_profile()->first();
        $options[$user->id] = $user_profile->last_name . " " . $user_profile->first_name . " " . $user_profile->second_name;

        return $options;
    }

}
