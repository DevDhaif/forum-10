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


    public function test_un_authenticated_user_may_not_add_replies(): void
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/channel/1/replies', [])
        ->assertRedirect('/login');
    }
    public function test_an_authenticated_user_can_participate_in_forum(): void
    {
        $this->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body(): void
    {
        $this->signIn()->withExceptionHandling();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())->assertSessionHasErrors();

    }

    public function test_unauthorized_users_cannot_delete_replies(): void
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);

        $this->delete("/replies/{$reply->id}")->assertRedirect('/login');
        $this->signIn()->delete("replies/{$reply->id}")->assertStatus(403);
    }

    public function test_authorized_users_can_delete_replies(): void
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this-> assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
    public function test_authorized_users_can_update_replies(): void
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id , 'body' => $updatedReply]);
    }

    public function test_unauthorized_users_cannot_update_replies(): void
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);

        $this->patch("/replies/{$reply->id}")->assertRedirect('/login');
        $this->signIn()->patch("replies/{$reply->id}")->assertStatus(403);
    }
}
