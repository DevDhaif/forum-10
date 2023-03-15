<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    use DatabaseMigrations;


    public function test_un_authenticated_user_may_not_add_replies() : void{
        $this->expectException('Illuminate\Auth\AuthenticationException');
            $this->post('/threads/channel/1/replies' , [])
            ->assertRedirect('/login');
    }
    public function test_an_authenticated_user_can_participate_in_forum(): void
    {
        $this->signIn();

        $thread =create(Thread::class);
        $reply = make(Reply::class);

        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body () : void{
        $this->signIn()->withExceptionHandling();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path().'/replies', $reply->toArray())->assertSessionHasErrors();

    }
}
