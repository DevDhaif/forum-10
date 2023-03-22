<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;

use App\Models\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show' ]);
    }

    public function getThreads(Channel $channel ,  ThreadFilters $filters){
        $threads = Thread::latest()->filter($filters);
        if($channel->exists){
            $threads->where('channel_id', $channel->id);
        }
        return $threads->get();
    }
// WIP - 2021-03-19 11:39:00 PM 
    public function index(Channel $channel  , ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel , $filters);
        return view('threads.index',
        [
            'threads' => $threads,
        ]);
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
        return redirect($thread->path());
    }
    public function show($channelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }
    public function edit(Thread $thread)
    {
    }
    public function update(Request $request, Thread $thread)
    {
    }
    public function destroy(Thread $thread)
    {
    }
}
