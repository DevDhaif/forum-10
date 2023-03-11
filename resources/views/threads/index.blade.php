@extends('layouts.app')
@section('content')

    <div class="mx-auto">
        @foreach ($threads as $thread)
            <div class="bg-white p-6 rounded-lg shadow mb-4">
                <div class="flex justify-between">

                            <p class="text-gray-600 text-sm mt-6">
                                {{ $thread->body }}
                            </p>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endsection
