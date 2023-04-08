@props(['reply'])

<div id="reply-{{$reply->id}}"
     class="bg-white relative p-4 rounded shadow mt-4 flex justify-between gap-x-4 items-center">



    <div class="relative space-y-2 mt-4 p-4 rounded shadow bg-gray-50 flex-1 ">
        <a href="{{ route('profile.show' , $reply->owner) }}" class="text-sm  text-blue-600 ">
            {{ $reply->owner->name }}
        </a>
        <span class="text-gray-600 text-sm pl-8">

            {{ $reply->created_at->diffForHumans() }}
        </span>
        <p v-if="true" class="mt-4 border-t pt-4 ">{{ $reply->body }}</p>

        @can('update' , $reply)
            <div class="flex gap-x-4 items-center">

                <div class=" ">
                    <form class="" action="/replies/{{$reply->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-100 px-4 py-2 border border-red-500 text-red-800 hover:bg-red-200"
                                type="submit"> Delete
                        </button>
                    </form>
                </div>

                {{-- use  a vue 3 example component and access its data then add a button to toggle the data --}}
                <example-component >
                    <button class="bg-blue-100 px-4 py-2 border border-blue-500 text-blue-800 hover:bg-blue-200"
                    > Edit
                    </button>
                </example-component>

                <div>

                </div>
            </div>

        @endcan
    </div>

    {{-- heart shape --}}
    <div class="flex items-center border rounded p-2">
        <form method="POST" action="/replies/{{ $reply->id }}/favorites">
            @csrf
            <button type="submit"
                    class="text-gray-600 text-sm disabled:text-gray-400" {{  $reply->isFavorited() ? 'disabled' : '' }}>
                {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
            </button>
        </form>
    </div>

    <div v-if="show"> yes</div>
    <div v-else> no</div>
</div>
