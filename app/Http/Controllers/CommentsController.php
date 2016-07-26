<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    protected $logged_user;

    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
    }

    public function store(CommentRequest $request )
    {
        $input = $request->all();
        $input['author_id'] = $this->logged_user->id;

        Comment::create($input);

       return back()->with('flash_message', 'Комментарий успешно добавлен.');
    }

    
}
