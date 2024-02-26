<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show' ]);
    }

    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {

            $threads->where('channel_id', $channel->id);

        }

        return $threads;

    }
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters)->get();

        if (request()->wantsJson()) {
            return $threads;
        }
        return view(
            'threads.index',
            [
                'threads' => $threads,
            ]
        );
    }
    public function create()
    {
        return view('threads.create');
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required',
                'body' => 'required',
                'channel_id' => 'required|exists:channels,id'
            ]
        );
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);
        return redirect($thread->path())->with('flash', 'Your thread has been successfully published');
    }
    public function show($channelId, Thread $thread)
    {
        $replies = $thread->replies()->paginate(20);

        // Check if each reply is favorited by the currently logged-in user
        foreach ($replies as $reply) {
            $reply->isFavorited = $reply->isFavoritedByUser(auth()->user());
        }
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $replies,
            'user' => auth()->user()
        ]);
    }
    public function edit(Thread $thread)
    {
    }
    public function update(Request $request, Thread $thread)
    {
    }
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads');
    }
    public function isFavorited(Thread $thread)
    {
        $isFavorited = $thread->isFavoritedByUser(auth()->user());
        return response()->json(['isFavorited' => $isFavorited]);
    }
}
