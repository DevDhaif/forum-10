@extends('layouts.app')
@section('content')
    <div class="container mx-auto  mt-6 flex space-x-8 justify-between items-start">
        <div class="w-3/4">
            <div class="bg-white p-4 rounded shadow w-full flex justify-between gap-x-4 items-center">
                <p class="flex-1 text-gray-600 text-sm">Published {{ $thread->created_at->diffForHumans() }} by <a
                        href="{{ route('profile.show' , $thread->creator) }}" class="text-blue-600 text-sm">{{ $thread->creator->name }}</a>
                    and currently has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}.</p>
                @can ('update' , $thread)
                <div class="">
                    <form action="{{ $thread->path() }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded py-2 px-2 hover:bg-red-600">Delete Thread</button>
                    </form>
                </div>
                @endcan
            </div>
            <div class="bg-white p-4 rounded shadow flex items-start justify-between">
                <p>{{ $thread->title }}</p>
                <div class="flex space-x-2 border rounded  px-2 py-1 ">
                    <form method="POST" action={{ route('replies.favorite', ['type'=> 'thread', 'id' => $thread->id]) }}>
                        @csrf
                        <button type="submit" class="text-white text-sm">
                            <svg class="w-4 h-4 transition-colors duration-500 {{ $thread->isFavorited() ? 'fill-red-500' : 'fill-blue-500' }}"
                             class="border border-gray-400 "
                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 18l-1.45-1.32C4.53 12.18 1 9.19 1 5.5 1 3.02 3.02 1 5.5 1c1.54 0 3.04.78 3.95 2.05C10.46 1.78 11.96 1 13.5 1 16.43 1 19 3.57 19 6.5c0 3.69-3.53 6.68-8.55 11.18L10 18z' : 'M10 18l-1.45-1.32C4.53 12.18 1 9.19 1 5.5 1 3.02 3.02 1 5.5 1c1.54 0 3.04.78 3.95 2.05C10.46 1.78 11.96 1 13.5 1 16.43 1 19 3.57 19 6.5c0 3.69-3.53 6.68-8.55 11.18L10 18z">
                                </path>
                            </svg>
                        </button>
                    </form>
                    <span class="text-sm">{{ $thread->favorites_count }} </span>
                </div>
            </div>
            <div class="bg-white p-4 rounded shadow">

                <p class="text-gray-600 text-sm mt-6">
                    {{ $thread->body }}
                </p>

            </div>
            {{-- a div for replies --}}
            <div class="bg-white p-4 rounded shadow mt-4">
                <p class="text-gray-600 text-sm mt-6">
                    This thread has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}.
                </p>
                @if (auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        @csrf
                        <div class="mt-6">
                            <textarea name="body" id="body" class="w-full" placeholder="Have something to say?" rows="5"></textarea>
                        </div>
                        <button type="submit"
                            class="bg-blue-500 text-white rounded py-2 px-2 hover:bg-blue-600 mt-4">Post</button>
                    </form>
                @endif
                @foreach ($replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
            <div class="py-2 mt-4 ">
                {{ $replies->links() }}
            </div>
        </div>
        <div class="w-1/4">
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-600 text-sm">This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                        href="{{ $thread->creator->path() }}" class="text-blue-600 text-sm">{{ $thread->creator->name }}</a>
                    and
                    currently has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }} . </p>
            </div>
        </div>
    </div>
@endsection
