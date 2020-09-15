<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-sm btn-outline-dark mr-1" @click="editing = true">Edit</button>
                <forrm method="POST" action="/replies/{{ $reply->id }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </forrm>
            </div>
        @endcan
    </div>
</reply>
