<?php

namespace App\Http\Controllers;

use App\Chanel;
use App\Thread;
use App\Filters\ThreadFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chanel $chanel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($chanel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'chanel_id' => 'required|exists:chanels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'chanel_id' => request('chanel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your thread has been publish');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($chanel, Thread $thread)
    {
        if (auth()->check())
            auth()->user()->read($thread);

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($chanel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * @param Chanel $chanel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Chanel $chanel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($chanel->exists) {
            $threads->where('chanel_id', $chanel->id);
        }

        $threads = $threads->get();
        return $threads;
    }

}
