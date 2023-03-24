@extends('layouts.app')
@section('content')
    <div class="container mx-auto  mt-6 space-y-4 flex space-x-8 justify-between">
        <div class="w-3/4">
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600 text-sm">Published {{ $thread->created_at->diffForHumans() }} by <a href="{{ $thread->creator->path() }}" class="text-blue-600 text-sm">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.</p>
            </div>
        <div class="bg-white p-4 rounded shadow">
        <p >{{ $thread->title }}</p>
        </div>
            <div class="bg-white p-4 rounded shadow">

            <p class="text-gray-600 text-sm mt-6">
                {{ $thread->body }}
            </p>
            </div>
            {{-- a div for replies --}}
        <div class="bg-white p-4 rounded shadow mt-4">
            <p class="text-gray-600 text-sm mt-6">
                This thread has {{ $thread->replies()->count() }} {{ Str::plural('comment', $thread->replies()->count()) }}.
            </p>
        @foreach ($thread->replies as $reply)
        <div class="space-y-2 p-4 rounded shadow bg-gray-50 mt-2">
            <p>{{ $reply->owner->name }} <span class="text-sm ml-4"> {{ $reply->created_at->diffForHumans() }} </span> </p>
            <p class="mt-4 border-t pt-4">{{ $reply->body }}</p>
        </div>
        @endforeach
    </div>
        @if (auth()->check())
            <form method="POST" action="{{ $thread->path()  . '/replies'}}">
                @csrf
                <div class="mt-6">
                    <textarea name="body" id="body" class="w-full" placeholder="Have something to say?" rows="5"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white rounded py-2 px-2 hover:bg-blue-600 mt-4">Post</button>
            </form>
        @endif
        </div>

        <div class="w-1/4">
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600 text-sm">This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="{{ $thread->creator->path() }}" class="text-blue-600 text-sm">{{ $thread->creator->name }}</a> and
                    currently has {{ $thread->replies()->count() }} {{ Str::plural('comment', $thread->replies()->count()) }} . </p>
            </div>
        </div>
    </div>
@endsection
