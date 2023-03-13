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
        // $thread = make(Thread::class);
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
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())->assertSee($thread->title);
    }
}
