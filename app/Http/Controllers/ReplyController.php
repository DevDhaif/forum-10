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

        $thread->addReply([
          'body' => request('body'),
          'user_id' => auth()->id(),
        ]);

        return redirect($thread->path())->with('flash', 'Your reply has been left!');

    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update([
            'body' => request('body'),
        ]);


return response()->json(['flash' => 'Your reply has been updated!', 'reply' => $reply]);

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
return back()->with('flash', 'Your reply has been deleted!');


    }
}
