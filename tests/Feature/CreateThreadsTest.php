<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {

        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_chanel()
    {
        factory('App\Chanel',2)->create();

        $this->publishThread(['chanel_id' => null])
            ->assertSessionHasErrors('chanel_id');

        $this->publishThread(['chanel_id' => 999])
            ->assertSessionHasErrors('chanel_id');
    }

    /** @test */
    function guest_cannot_delete_threads()
    {
        $thread = create('App\Thread');

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');
    }

    /** @test */
    function a_thread_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    function threads_may_only_be_deleted_by_those_who_have_permission()
    {
        //TODO:
    }

    protected function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
