<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        $this->validate(
            request(),
            [
                'body' => 'required',
            ]
        );

        return  $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update([
            'body' => request('body'),
        ]);

        return back()->with('flash', 'success');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        // return back( )->with('flash', 'Your reply has been deleted!');
        // return back()->with('flash', 'Your reply has been deleted!');

    }
}
