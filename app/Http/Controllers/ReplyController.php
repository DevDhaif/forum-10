<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;

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

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        $thread = $thread->fresh();

        $replies = $thread->replies()->latest()->paginate(10)->withPath("/threads/{$thread->channel->slug}/{$thread->id}");
        if (request()->expectsJson()) {
            return response()->json([
                'reply' => $reply,
                'flash' => 'Your reply has been left!',
                'replies' => $replies,
                'thread' => $thread,
            ]);
        }
        session()->flash('message', 'Your reply has been left!');

        return redirect($thread->path());;
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update([
            'body' => request('body'),
        ]);
        if (request()->expectsJson()) {

            return response()->json([
                'reply' => $reply,
                'flash' => 'Your reply has been updated!'
            ]);
        }
        session()->flash('message', 'Your reply has been updated!');
        return redirect()->back();
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $thread = $reply->thread;
        $reply->delete();
        $replies = $thread->replies()->latest()->paginate(10)->withPath("/threads/{$thread->channel->slug}/{$thread->id}");

        if (request()->expectsJson()) {
            return response()->json([
                'flash' => 'Your reply has been deleted!',
                'replies' => $replies,
                'thread' => $thread,
            ]);
        }
        session()->flash('message', 'Your reply has been deleted!');
        return redirect()->back();
    }
    public function isFavorited(Reply $reply)
    {
        $isFavorited = $reply->isFavoritedByUser(auth()->user());

        return response()->json(['isFavorited' => $isFavorited]);
    }
}
