@extends('layouts.app')

@section('content')
    {{-- display the user data --}}
    <div class="mx-auto">
        <h1 class="text-2xl font-bold"> {{ $profileUser->name }}</h1>
        <p>Since {{ $profileUser->created_at->diffForHumans() }}</p>
        {{ $threads->count() }} {{ Str::plural('thread', $threads->count()) }}
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {{-- display the threads --}}
            @foreach ($threads as $thread)
            <div class="flex border border-gray-300 bg-white gap-x-4 rounded-lg p-4 justify-between">
                <h1 class="flex-1">
                    <a href="{{ $thread->path() }}">
                        {{ $thread->title }}
                    </a>
                </h1>
                <p class="text-blue-500 text-sm">{{  $thread->created_at->diffForHumans() }}</p>
            </div>

            @endforeach

                {{-- links to the next page --}}
            </div>
            <div class="mt-8 py-8 flex ">
                {{ $threads->links() }}
            </div>
    </div>

@endsection
