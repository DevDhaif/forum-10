@props(['reply'])
<div class="bg-white p-4 rounded shadow mt-4 flex justify-between items-center">

    <div class="space-y-2 mt-4 p-4 rounded shadow bg-gray-50 flex-1">
        <p>{{ $reply->owner->name }} <span class="text-sm ml-4"> {{ $reply->created_at->diffForHumans() }} </span> </p>
        <p class="mt-4 border-t pt-4">{{ $reply->body }}</p>
    </div>

    {{-- heart shape --}}
    <div class="flex items-center">
        {{ $reply->favorites()->count()    }}
        <form method="POST" action="/replies/{{ $reply->id }}/favorites">
            @csrf
            <button type="submit" class="text-gray-600 text-sm disabled:text-gray-400" {{  $reply->isFavorited() ? 'disabled' : '' }}>
                {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
            </button>
        </form>
    </div>

</div>
