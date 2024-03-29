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
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;

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
        $this->get('/threads/create')
            ->assertRedirect('/login');
        $this->post('/threads')
            ->assertRedirect('/login');
    }
    public function test_an_authenticated_user_can_create_new_forum_thread(): void
    {
        $this->signIn();

        $channel = Channel::factory()->create();
        $thread =   Thread::factory()->make(['channel_id' => $channel->id]);

        $threadData = [
            'title' => $thread->title,
            'body' => $thread->body,
            'channel_id' => $channel->id,
        ];

        $response = $this->post('/threads', $threadData);

        $createdThread = Thread::where('title', $threadData['title'])
            ->where('body', $threadData['body'])
            ->first();
        // dd($thread->toArray());

        $this->assertNotNull($createdThread, 'Thread was not created');

        $response->assertRedirect(route('threads.show', [$createdThread->channel->slug, $createdThread->id]));

        $this->assertDatabaseHas('threads', ['title' => $createdThread->title, 'body' => $createdThread->body]);

        $response = $this->get(route('threads.show', [$createdThread->channel->slug, $createdThread->id]));

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Thread/Show')
                ->has(
                    'thread',
                    fn (AssertableInertia $page) => $page
                        ->where('title', $createdThread->title)
                        ->where('body', $createdThread->body)
                        ->etc()
                )
        );
    }

    /** @test */
    public function a_thread_requires_a_title(): void
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body(): void
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel(): void
    {
        $channels = Channel::factory(5)->create();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 9999])->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn()->withExceptionHandling();
        $thread = Thread::factory()->make($overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
