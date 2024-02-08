@extends('layouts.app')

@section('content')
    {{-- display the user data --}}
    <div class="mx-auto">
        <h1 class="text-2xl font-bold"> {{ $profileUser->name }}</h1>
        <div class="flex space-x-2 mt-4">
            <h1 class=" px-4 py-1 border rounded-xl border-blue-500 bg-blue-100 text-blue-800  font-semibold">{{ $profileUser->university->name }}</h1>
            <h1 class=" px-4 py-1 border rounded-xl border-green-500 bg-green-100 text-green-800  font-semibold">{{ $profileUser->field->name }}</h1>
        </div>
        <p class="mt-2">Since {{ $profileUser->created_at->diffForHumans() }}</p>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {{-- display the threads --}}


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
