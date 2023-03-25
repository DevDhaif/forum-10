@props(['reply'])
<div class="space-y-2 mt-4 p-4 rounded shadow bg-gray-50 ">
    <p>{{ $reply->owner->name }} <span class="text-sm ml-4"> {{ $reply->created_at->diffForHumans() }} </span> </p>
    <p class="mt-4 border-t pt-4">{{ $reply->body }}</p>
</div>
