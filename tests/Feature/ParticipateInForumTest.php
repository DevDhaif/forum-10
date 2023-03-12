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

    // public function test_an_unauthenticated_user_may_not_add_replies(): void
    // {
    //     $this->expectException('Illuminate\Auth\AuthenticationException');
    //     $this->post('threads/1/replies', []);
    // }
    public function test_an_authenticated_user_can_participate_in_forum(): void
    {
        $this->be($user = User::factory()->create());
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make();
        $this->post($thread->path().'/replies', $reply->toArray());
        $response = $this->get($thread->path())->assertSee($reply->body);
    }
}
