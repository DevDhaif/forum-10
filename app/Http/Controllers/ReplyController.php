<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store($channelId ,Thread $thread)
    {
        $this->validate( request(),
            [
                'body' => 'required',
            ]
        );
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),        ]);
        return back()->with('flash', 'Your reply has been left!');

    }
}
