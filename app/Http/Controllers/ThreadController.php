<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ThreadController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'show', 'getReplies']);
    }

    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
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
                'channel' => $channel->name,
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
        Reply::loadFavoritedReplyIdsForUser(auth()->user());
        $replies = $thread->replies()->paginate(5);

        // Check if each reply is favorited by the currently logged-in user
        foreach ($replies as $reply) {
            $reply->isFavorited = $reply->isFavoritedByUser(auth()->user());
        }
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $replies,
            'user' => auth()->user(),
            'pagination' => [
                'currentPage' => $replies->currentPage(),
                'lastPage' => $replies->lastPage(),
                'next_page_url' => $replies->nextPageUrl(),
                'prev_page_url' => $replies->previousPageUrl(),
                'path' => $replies->path(),
            ]
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
    public function getReplies($channel, $threadId, Request $request)
    {
        $thread = Thread::findOrFail($threadId);
        $page = $request->query('page', 1);
        $replies = $thread->replies()->paginate(5, ['*'], 'page', $page);
        // return json if expected
        if (request()->wantsJson()) {
            return response()->json([
                'replies' => $replies,
                'pagination' => [
                    'currentPage' => $replies->currentPage(),
                    'lastPage' => $replies->lastPage(),
                    'next_page_url' => $replies->nextPageUrl(),
                    'prev_page_url' => $replies->previousPageUrl(),
                    'path' => $replies->path(),
                ]
            ]);
        } else {

            return view('threads.show', [
                'thread' => $thread,
                'replies' => $replies,
                'user' => auth()->user(),
                'pagination' => [
                    'currentPage' => $replies->currentPage(),
                    'lastPage' => $replies->lastPage(),
                    'next_page_url' => $replies->nextPageUrl(),
                    'prev_page_url' => $replies->previousPageUrl(),
                    'path' => $replies->path(),
                ]
            ]);
        }
    }
}
