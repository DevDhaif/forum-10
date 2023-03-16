<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads(): void
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        // fwrite(STDERR, print_r($thread->toArray(), true));
         $this->get('/threads/create')
            ->assertRedirect('/login');
        $this->post('/threads')
            ->assertRedirect('/login');
    }
    public function test_an_authenticated_user_can_create_new_forum_thread(): void
    {
        // $user = create(User::class);
        $this->signIn();

        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());
        // dd($response->headers->get('Location'));


        $this->get($response->headers->get('Location'))->assertSee($thread->title);
    }

    /** @test */
    public function a_thread_requires_a_title () :void{
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body () :void{
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel () :void{
        $channels = Channel::factory(5)->create();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 6])->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = []){
        $this->signIn()->withExceptionHandling();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
