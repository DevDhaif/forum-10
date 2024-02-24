@component('profile.partials.activity.activity')
    @slot('heading')
        <h1 class="text-xl font-bold"> {{ $profileUser->name }}</h1>
        @if ($activity->subject)
            <p class="text-sm">favorited a {{ strtolower(class_basename($activity->subject->favorited_type)) }} on
                @if ($activity->subject?->favorited_type === 'App\\Models\\Thread')
                    <a href="{{ route('threads.show', ['channel' => $activity->subject->favorited->channel->slug, 'thread' => $activity->subject->favorited->id]) }}"
                        class="text-blue-500">
                        {{ $activity->subject->favorited->title }}
                    </a>
                @elseif($activity->subject?->favorited_type === 'App\\Models\\Reply' && $activity->subject?->favorited->thread)
                    <a href="{{ route('threads.show', ['channel' => $activity->subject->favorited->thread->channel->slug, 'thread' => $activity->subject->favorited->thread->id]) }}"
                        class="text-blue-500">
                        {{ $activity->subject->favorited->body }}
                    </a>
                @endif
                {{ $activity->created_at->diffForHumans() }}
            </p>

        @endif
    @endslot
    @slot('body')
        @if ($activity->subject)
            <p class="text-sm"> {{ $activity->subject->favorited->body }}</p>
        @else
            <p class="text-sm"> The favorited item has been deleted</p>
        @endif
    @endslot
@endcomponent
