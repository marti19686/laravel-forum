<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChanelTest extends TestCase
{
    use DatabaseMigrations;

   /** @test */
    public function a_chanel_consists_of_threads()
    {
        $chanel = create('App\Chanel');
        $thread = create('App\Thread', ['chanel_id' => $chanel->id]);

        $this->assertTrue($chanel->threads->contains($thread));
    }
}
