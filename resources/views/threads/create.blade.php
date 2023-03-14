@extends('layouts.app')
@section('content')

    <div class="container mx-auto  mt-6 space-y-4">
        <div>
            <h1 class="text-2xl font-bold">Create a Thread</h1>

        </div>

        @if (auth()->check())
        <form method="POST" action="/threads" class="space-y-4">
                @csrf
                <div class="mt-6">
                    <input type="text" name="title" id="title" class="w-full" placeholder="Title">
                </div>
                <div class="mt-6">
                    <textarea name="body" id="body" class="w-full" placeholder="Have something to say?" rows="5"></textarea>
                </div>
                <select name="channel_id" id="channel_id" class="w-full">
                    <option value="">Choose One...</option>
                    @foreach ($channels as $channel)
                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-500 text-white rounded py-2 px-2 hover:bg-blue-600 mt-4">Post</button>
                 </form>
            @endif
        </div>

@endsection
