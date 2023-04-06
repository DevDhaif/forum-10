@component('profile.partials.activity.activity')
    @slot('heading')
        <h1 class="text-xl font-bold"> {{ $profileUser->name }}</h1>
        <p class="text-sm">favorited a reply on
            <a href="{{ $activity->subject?->favorited->path() }}" class="text-blue-500">
                {{ $activity->subject?->favorited->body }}
            </a>
            {{ $activity->subject?->created_at->diffForHumans() }}
        </p>
    @endslot
    @slot('body')
        <p class="text-sm"> {{ $activity->subject?->favorited->body }}</p>
    @endslot
@endcomponent
