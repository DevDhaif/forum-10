@extends('layouts.app')
@section('content')
    <div class="mx-auto">
        <h1 class="text-2xl font-bold"> All Threads</h1>
        @if (count($threads) == 0)
            <div class="px-4 py-3">
                <p class="text-sm leading-5">No threads yet.</p>
            </div>
        @endif
        @foreach ($threads as $thread)
            <div class="bg-white p-6  rounded-lg shadow mb-4">
                <div class="space-y-4">
                    <div class="flex w-full justify-between items-center mt-4 py-4">
                        <div>
                            <a href="{{ $thread->path() }}" class="flex-1 text-blue-600 text-sm ">
                                {{ $thread->title }}
                            </a>
                            <a href="#" class="text-red-500 px-4"> {{ $thread->channel->name ?? '' }} </a>
                        </div>
                        <p class="text-gray-600 text-sm ">
                            Published {{ $thread->created_at->diffForHumans() }}
                            by <a href="{{ $thread->creator->path() }}"
                                class="text-blue-600 text-sm">
                                {{ $thread->creator->name }}</a> and   has {{ $thread->replies_count }}
                            {{ Str::plural('reply', $thread->replies_count) }}.
                         </p>
                    </div>
                    {{-- turncate the body show only 100 characters --}}

                    <p class="text-gray-600 text-sm mt-6">
                        {{ Str::limit($thread->body, 100) }}
                        {{-- if the body is less than 100 characters then show the body --}}
                        @if (strlen($thread->body) > 100)
                            <a href="{{ $thread->path() }}" class="text-blue-600 text-sm">Read more</a>
                        @endif

                    </p>



                </div>
            </div>
        @endforeach
    </div>
@endsection
