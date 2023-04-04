@component('profile.partials.activity.activity')
    @slot('heading')
        <h1 class="text-xl font-bold"> {{ $profileUser->name }}</h1>
        <p class="text-sm">created a reply on
            <a href="{{ $activity->subject?->path() }}" class="text-blue-500">
                {{ $activity->subject?->thread->title }}
            </a>
            {{ $activity->subject?->created_at->diffForHumans() }}
        </p>
        @endslot
    @slot('body')
        <h1 class="text-xl font-bold"> {{ $activity->subject?->title }}</h1>
        <p class="text-sm"> {{ $activity->subject?->body }}</p>
        @endslot
@endcomponent
