<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_browse_threads()
    {
        $thread = factory(\App\Thread::class)->create();

        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }

    /** @test */
    function a_user_can_read_a_single_thread()
    {
        $thread = factory(\App\Thread::class)->create();

        $response = $this->get('/threads/'. $thread->id);

        $response->assertSee($thread->title);
    }
}
