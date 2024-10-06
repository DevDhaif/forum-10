<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Requests\CreateThreadRequest;
use App\Models\Channel;
use App\Models\Point;
use App\Models\Reply;
use App\Models\Thread;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ThreadController extends Controller
{
    public function __construct() {}

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
        $threads = $this->getThreads($channel, $filters)->latest()->paginate(50);
        $threads->appends($request->query());

        return Inertia::render('Thread/Index', [
            'threads' => $threads,
            'channel' => $channel->slug,
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ],
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
            Point::create([
                'user_id' => $thread->user_id,
                'source' => 'thread',
                'source_id' => $thread->id,
                'points' => 3,
            ]);
            $achievementService = new AchievementService();
            $achievementService->checkForAchievements($thread->creator);
            session()->flash('success', 'threadLeft');

            return redirect()->route('threads.show', [$thread->channel->slug, $thread->id]);
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem creating your thread');
            return back();
        }
    }
    public function show($channelSlug, Thread $thread)
    {
        if (!session()->has("viewed_threads.{$thread->id}")) {
            $thread->increment('visits');
            if ($thread->visits % 100 == 0) {
                Point::create([
                    'user_id' => $thread->user_id,
                    'source' => 'visits',
                    'source_id' => $thread->id,
                    'points' => 10,
                ]);
                $achievementService = new AchievementService();
                $achievementService->checkForAchievements($thread->creator);
            }
            session()->put("viewed_threads.{$thread->id}", true);
        }


        $channels = Cache::get('channels');
        $channel = $channels->firstWhere('slug', $channelSlug);

        if (!$channel || $thread->channel_id !== $channel->id) {
            abort(404);
        }
        $relatedThreads = Thread::where('channel_id', $thread->channel->id)->latest()->take(10)->get();
        Reply::loadFavoritedReplyIdsForUser(auth()->user());

        $replies = $thread->replies()->latest()->paginate(10);

        foreach ($replies as $reply) {
            $reply->isFavorited = $reply->isFavoritedByUser(auth()->user());
        }

        $user = auth()->user();
        if ($user && $user->roles->isNotEmpty()) {
            $user->role = $user->roles->first()->name;
        }
        return Inertia::render('Thread/Show', [
            'thread' => $thread,
            'replies' => $replies,
            'user' => $user,
            'relatedThreads' => $relatedThreads,
            'flashMessage' => session('success'),
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
        try {
            if ($thread->channel_id != $channel->id) {
                abort(404, 'Thread not found');
            }
            $this->authorize('update', $thread);

            $thread->update($request->only('title', 'body', 'channel_id'));

            $newChannel = Channel::find($request->channel_id);

            session()->flash('success', 'threadUpdated');

            return redirect()->route('threads.show', [$newChannel->slug, $thread->id]);
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem updating your thread');
            return back();
        }
    }
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('delete', $thread);
        try {
            Point::where([
                'user_id' => $thread->user_id,
                'source' => 'thread',
                'source_id' => $thread->id,
            ])->delete();
            $thread->delete();

            session()->flash('success', 'threadDeleted');

            return redirect()->route('threads', $channel);
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem deleting your thread');
            return back();
        }
    }
}
