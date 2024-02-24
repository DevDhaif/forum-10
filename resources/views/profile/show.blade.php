@extends('layouts.app')

@section('content')
    {{-- display the user data --}}
    <div class="mx-auto">
        <h1 class="text-2xl font-bold"> {{ $profileUser->name }}</h1>
        <h1 class="text-2xl font-bold"> {{ $profileUser->email }}</h1>
        <div class="flex space-x-2 mt-4">
            <h1 class=" px-4 py-1 border rounded-xl border-blue-500 bg-blue-100 text-blue-800  font-semibold">{{ $profileUser->university->name }}</h1>
            <h1 class=" px-4 py-1 border rounded-xl border-green-500 bg-green-100 text-green-800  font-semibold">{{ $profileUser->field->name }}</h1>
        </div>
        <p class="mt-2">Since {{ $profileUser->created_at->diffForHumans() }}</p>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {{-- display the threads --}}
            @forelse ($threads as $thread)
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-600 text-sm">Published {{ $thread->created_at->diffForHumans() }} by <a
                            href="{{ route('profile.show' , $thread->creator) }}"
                            class="text-blue-600 text-sm">{{ $thread->creator->name }}</a>
                        and currently has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}.</p>
                    <p>{{ $thread->title }}</p>
                    <p class="text-gray-600 text-sm mt-6 w-52 truncate line-clamp-2 ">
                        {{ $thread->body }}
                    </p>
                    <div class="flex justify-between gap-x-4 items-center">
                        @can ('update' , $thread)
                            <div class="">
                                <form action="{{ $thread->path() }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white rounded py-2 px-2 hover:bg-red-600">Delete Thread</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <h1>no threads yet</h1>
            @endforelse
            {{-- all the threads of this user --}}
            {{-- <div class="mt-8 py-8  ">
                <h2 class="text-2xl font-bold">Threads</h2>
                @forelse ($threads as $thread)
                    <div class="bg-white p-4 rounded shadow">
                        <p class="text-gray-600 text-sm">Published {{ $thread->created_at->diffForHumans() }} by <a
                                href="{{ route('profile.show' , $thread->creator) }}"
                                class="text-blue-600 text-sm">{{ $thread->creator->name }}</a>
                            and currently has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}.</p>
                        <p>{{ $thread->title }}</p>
                        <p class="text-gray-600 text-sm mt-6">
                            {{ $thread->body }}
                        </p>
                        <div class="flex justify-between gap-x-4 items-center">
                            @can ('update' , $thread)
                                <div class="">
                                    <form action="{{ $thread->path() }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white rounded py-2 px-2 hover:bg-red-600">Delete Thread</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                @empty
                    <h1>no threads yet</h1>
                @endforelse

        </div> --}}
            {{-- links to the next page --}}
        </div>
        <div class="mt-8 py-8  ">
            <h2 class="text-2xl font-bold">Activities</h2>
            @forelse ($activities as $date => $activity)
                {{ $date }}
                @foreach ($activity as $record)

                    <div class="flex border border-gray-300 mt-4 gap-x-4   justify-between ">
                        @if(view()->exists("profile.partials.activity.{$record->type}"))
                        @include("profile.partials.activity.{$record->type}" , ['activity' => $record])
                        @endif
                    </div>

                @endforeach
            @empty
                <h1>no activities yet</h1>
            @endforelse
        </div>
        {{-- <div class="mt-8 py-8 flex ">
            {{ $threads->links() }}
        </div> --}}
    </div>

@endsection
