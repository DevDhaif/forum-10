@extends('layouts.app')

@section('content')
    {{-- display the user data --}}
    <div class="mx-auto">
        <h1 class="text-2xl font-bold"> {{ $profileUser->name }}</h1>
        <p>Since {{ $profileUser->created_at->diffForHumans() }}</p>
        <div>
            {{ $threads->count() }} {{ Str::plural('thread', $threads->count()) }}
            {{ $threads->channels->count() }} {{ Str::plural('channel', $threads->channels->count()) }}
            @foreach ($threads as $thread )
            <div>
                <h1>hi</h1>
                <h1>
                    <a href="{{ $thread->path() }}">
                        {{ $thread->title }} yeyeyeyeye
                    </a>
                </h1>
            </div>

            @endforeach

                {{-- links to the next page --}}
                {{-- {{ $threads->links() }} --}}
        </div>
    </div>

@endsection
