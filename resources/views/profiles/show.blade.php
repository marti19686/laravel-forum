@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>
                    {{ $profileUser->name }}
                </h1>
                <h4>Since {{ $profileUser->created_at->diffForHumans() }}</h4>
            </div>

            @foreach($threads as $thread)
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="level">
                        <span class="flex">
                            <a href="#">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                        </span>

                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
