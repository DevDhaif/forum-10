@props(['reply'])
<div id="reply-{{$reply->id}}" class="bg-white relative p-4 rounded shadow mt-4 flex justify-between gap-x-4 items-center">

    <div class="space-y-2 mt-4 p-4 rounded shadow bg-gray-50 flex-1 ">
        <a href="{{ route('profile.show' , $reply->owner) }}" class="text-sm  text-blue-600 ">
                {{ $reply->owner->name }}
        </a>
        <span class="text-gray-600 text-sm pl-8">

            {{ $reply->created_at->diffForHumans() }}
        </span>
        <p class="mt-4 border-t pt-4 ">{{ $reply->body }}</p>
    </div>

    {{-- heart shape --}}
    <div class="flex items-center border rounded p-2">
        <form method="POST" action="/replies/{{ $reply->id }}/favorites">
            @csrf
            <button type="submit" class="text-gray-600 text-sm disabled:text-gray-400" {{  $reply->isFavorited() ? 'disabled' : '' }}>
                {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
            </button>
        </form>
    </div>

</div>
