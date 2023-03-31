@extends('layouts.app')

@section('content')
    {{-- display the user data --}}
    <div class="mx-auto">
        <h1 class="text-2xl font-bold"> {{ $profileUser->name }}</h1>
        <p>Since {{ $profileUser->created_at->diffForHumans() }}</p>
        {{ $threads->count() }} {{ Str::plural('thread', $threads->count()) }}
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {{-- display the threads --}}


                {{-- links to the next page --}}
            </div>
            <div class="mt-8 py-8  ">
                <h2 class="text-2xl font-bold">Activities</h2>
                @foreach ($activities as $activity)
                <div class="flex border border-gray-300 mt-4 gap-x-4 rounded-lg  justify-between">
                    @include('profile.partials.activity.' . $activity->type)
                </div>
                @endforeach
            </div>
            {{-- <div class="mt-8 py-8 flex ">
                {{ $threads->links() }}
            </div> --}}
    </div>

@endsection
