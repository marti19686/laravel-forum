<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($chanelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($chanelId, Thread $thread)
    {
        $this->validate(request(),[
            'body' => 'required'
        ]);

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update([
            'body' => request('body')
        ]);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }
}
