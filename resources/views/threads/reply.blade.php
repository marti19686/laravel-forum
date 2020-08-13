<div id="reply-{{ $reply->id }}" class="card mt-3">
    <div class="card-header">
        <div class="level">
            <div class="flex">
                <h6>
                    <a href="/profiles/{{ route('profile', $reply->owner) }}">
                        {{$reply->owner->name}}
                    </a> said {{ $reply->created_at->diffForHumans() }}...
                </h6>
            </div>

            <div class="d-flex justify-content-end">
                <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                    @csrf

                    <button type="submit" class="btn btn-outline-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
