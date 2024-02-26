@extends('layouts.app')
@section('content')
    <thread-page :thread="{{ $thread->toJson() }}" :user='@json(Auth::user())'
        :replies="{{ $replies->toJson() }}"></thread-page>
    {{-- <div class="py-2 mt-4 ">
        {{ $replies->links() }}
    </div> --}}
@endsection
