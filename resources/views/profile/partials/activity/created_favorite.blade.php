@component('profile.partials.activity.activity')
    @slot('heading')
        <h1 class="text-xl font-bold"> {{ $profileUser->name }}</h1>
        <p class="text-sm">favorited a reply on
            @if($activity->subject?->favorited->thread && $activity->subject?->favorited->thread->channel)
                <a href="{{ route('threads.show', ['channel' => $activity->subject->favorited->thread->channel->slug, 'thread' => $activity->subject->favorited->thread->id]) }}" class="text-blue-500">
                    {{ $activity->subject->favorited->body }}
                </a>
            @else
                Missing thread or channel
            @endif
            {{ $activity->subject?->created_at->diffForHumans() }}
        </p>
    @endslot
    @slot('body')
        <p class="text-sm"> {{ $activity->subject?->favorited->body }}</p>
    @endslot
@endcomponent
