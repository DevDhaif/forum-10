 <div class=" flex flex-col gap-2 w-full">
     <div class="p-2 flex gap-x-2 items-center">
         <h1 class="text-xl font-bold"> {{ $profileUser->name }}</h1>
         <p class="text-sm">created a thread
            <a href="{{ $activity->subject->path() }}" class="text-blue-500">
                {{ $activity->subject->title }}
            </a>
            {{ $activity->subject->created_at->diffForHumans() }}
        </p>
     </div>

     {{-- horizontal line --}}
        <div class="border-b border-gray-300"></div>
        <div class="p-4">
            <h1 class="text-xl font-bold"> {{ $activity->subject->title }}</h1>
            <p class="text-sm"> {{ $activity->subject->body }}</p>
        </div>
 </div>
