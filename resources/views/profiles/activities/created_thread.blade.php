@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} publish a  <a href="{{ $activity->subject->path() }}">"{{ $activity->subject->title }}"</a> thread
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
