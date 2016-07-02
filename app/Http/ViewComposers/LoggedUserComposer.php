<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class LoggedUserComposer
{
    /**
     * Logged user
     *
     * @var logged_user
     */
    protected $logged_user;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $authentication = \App::make('authenticator');        
        $this->logged_user = $authentication->getLoggedUser();  
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logged_user', $this->logged_user);
    }
}