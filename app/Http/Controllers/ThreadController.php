<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Requests\CreateThreadRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ThreadController extends Controller
{
    public function __construct()
    {
    }

    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        // return json threads
        return $threads;
    }
    public function index(Channel $channel, ThreadFilters $filters, Request $request)
    {
        $threads = $this->getThreads($channel, $filters)->paginate(5);
        $threads->appends($request->query());

        return Inertia::render('Thread/Index', [
            'threads' => $threads,
            'channel' => $channel->slug,
        ]);
    }
    public function create()
    {
        return Inertia::render(
            'Thread/Create',
            [
                'user' => auth()->user(),
            ]
        );
    }
    public function store(CreateThreadRequest $request)
    {
        try {

            $thread = Thread::create(
                array_merge(
                    $request->validated(),
                    ['user_id' => auth()->id()]
                )
            );
            session()->flash('success', 'Your thread has been left!');

            return Inertia::location(route('threads.show', [$thread->channel->slug, $thread->id]));
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem creating your thread');
            return back();
        }
    }
    public function show($channelSlug, Thread $thread)
    {
        if (!session()->has("viewed_threads.{$thread->id}")) {
            $thread->increment('visits');
            session()->put("viewed_threads.{$thread->id}", true);
        }


        $channels = Cache::get('channels');
        $channel = $channels->firstWhere('slug', $channelSlug);

        if (!$channel || $thread->channel_id !== $channel->id) {
            abort(404);
        }

        Reply::loadFavoritedReplyIdsForUser(auth()->user());

        $replies = $thread->replies()->latest()->paginate(10);

        foreach ($replies as $reply) {
            $reply->isFavorited = $reply->isFavoritedByUser(auth()->user());
        }
        return Inertia::render('Thread/Show', [
            'thread' => $thread,
            'replies' => $replies,
            'user' => auth()->user(),
        ]);
    }
    public function edit(Channel $channel, Thread $thread)
    {
        if ($thread->channel_id !== $channel->id) {
            abort(404);
        }
        $this->authorize('update', $thread);
        return Inertia::render('Thread/Edit', [
            'thread' => $thread,
            'user' => auth()->user(),
        ]);
    }
    public function update(Request $request, Channel $channel, Thread $thread)
    {
        if ($thread->channel_id != $channel->id) {
            abort(404, 'Thread not found');
        }
        $this->authorize('update', $thread);
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);
        $thread->update($request->only('title', 'body', 'channel_id'));
        $newChannel = Channel::find($request->channel_id);
        session()->flash('success', 'Your thread has been updated!');

        return Inertia::location(route('threads.show', [$newChannel->slug, $thread->id]));
    }
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->delete();

        $threads = Thread::latest()->paginate(5);
        return Inertia::location(route('threads'));
    }
}
