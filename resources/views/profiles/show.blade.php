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

            @foreach($activities as $date => $activity)
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h3 class="header">{{ $date }}</h3>
                </div>
                @foreach($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @endforeach

            <div class="mt-4">
{{--                {{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection
