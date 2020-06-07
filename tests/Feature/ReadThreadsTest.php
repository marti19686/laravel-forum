<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    function a_user_can_browse_threads()
    {
//        $thread = create('App\Thread');

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $replay = factory(\App\Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($replay->body);

    }

    /** @test */
    function a_user_can_filter_threads_according_to_a_chanel()
    {
        $chanel = create('App\Chanel');
        $threadInChannel = create('App\Thread', ['chanel_id' => $chanel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' .$chanel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee(($threadNotInChannel->title));
    }

}
