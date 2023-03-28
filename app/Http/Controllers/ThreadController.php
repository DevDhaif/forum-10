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

    public function getThreads(Channel $channel ,  ThreadFilters $filters){


        $threads = Thread:: latest()->filter($filters);


        if($channel->exists){

            $threads->where('channel_id', $channel->id)->with(['channel',  'creator']);


        }
        return $threads->get();

    }
    public function index(Channel $channel  , ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel , $filters);

        if (request()->wantsJson()) {
            return $threads;
        }
        // get the sql query

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


        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);


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
