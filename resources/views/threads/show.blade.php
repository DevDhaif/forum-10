@extends('layouts.app')
@section('content')
    <div class="container mx-auto  mt-6 space-y-4">
        <p >{{ $thread->title }}</p>

        <a href="{{ $thread->creator->path() }}"
         class="text-blue-600 text-sm mt-6">
            {{ $thread->creator->name }}
        </a>
            <p class="text-gray-600 text-sm mt-6">
                {{ $thread->body }}
            </p>

        @foreach ($thread->replies as $reply)
        <div class="space-y-2 p-4 rounded shadow bg-white">
            <p>{{ $reply->owner->name }} <span class="text-sm ml-4"> {{ $reply->created_at->diffForHumans() }} </span> </p>
            <p class="mt-4 border-t pt-4">{{ $reply->body }}</p>
        </div>
        @endforeach
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
@endsection
