@props(['reply'])
<div id="reply-{{$reply->id}}"
     class="bg-white relative p-4 rounded shadow mt-4 flex justify-between gap-x-4 items-center">


     <reply :reply="{{ json_encode($reply) }}" ></reply>

    {{-- <div class="relative space-y-2 mt-4 p-4 rounded shadow bg-gray-50 flex-1 ">
        <a href="{{ route('profile.show' , $reply->owner) }}" class="text-sm  text-blue-600 ">
            {{ $reply->owner->name }}
        </a>
        <span class="text-gray-600 text-sm pl-8">

            {{ $reply->created_at->diffForHumans() }}
        </span>
        <div v-if="editing">
            <textarea></textarea>
        </div>
        <div v-else>
            {{ $reply->body }}
        </div>
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

                    <button @click="editing = true" class="bg-blue-100 px-4 py-2 border border-blue-500 text-blue-800 hover:bg-blue-200">
                         Edit
                    </button>
            </div>
            @endcan


        </div> --}}

        {{-- heart shape --}}
    <div class="flex space-x-2 border rounded  p-2">
        <form method="POST" action={{ route('replies.favorite', ['type'=> 'reply', 'id' => $reply->id]) }}>
            @csrf
            <button type="submit" class="text-white text-sm">
                <svg class="w-4 h-4 transition-colors duration-500 {{ $reply->isFavorited() ? 'fill-red-500' : 'fill-blue-500' }}"
                 class="border border-gray-400 "
                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 18l-1.45-1.32C4.53 12.18 1 9.19 1 5.5 1 3.02 3.02 1 5.5 1c1.54 0 3.04.78 3.95 2.05C10.46 1.78 11.96 1 13.5 1 16.43 1 19 3.57 19 6.5c0 3.69-3.53 6.68-8.55 11.18L10 18z' : 'M10 18l-1.45-1.32C4.53 12.18 1 9.19 1 5.5 1 3.02 3.02 1 5.5 1c1.54 0 3.04.78 3.95 2.05C10.46 1.78 11.96 1 13.5 1 16.43 1 19 3.57 19 6.5c0 3.69-3.53 6.68-8.55 11.18L10 18z">
                    </path>
                </svg>
            </button>
        </form>
        <span class="text-sm">{{ $reply->favorites_count }} </span>
    </div>
</div>

