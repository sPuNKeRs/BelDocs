<?php
namespace App\Helpers;
use App\User;

class SprHelper
{

    public static function getUserSpr()
    {
        $users = User::all();

        dd($users);

        return $users;
    }

}