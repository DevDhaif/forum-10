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

class ThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    use DatabaseMigrations;
    // a setup function to run before each test to create a user and sign them in and a thread
    public function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class);
        $this->thread = create(Thread::class);

        $this->actingAs($this->user);
    }


    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_single_thread() : void
    {
        $response = $this->get("/threads/" . $this->thread->channel . '/' .$this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_on_a_thread()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id ]);
        // fwrite(STDERR, print_r($reply->toArray(), true));

        $response = $this->get("/threads/" . $this->thread->channel . '/' . $this->thread->id);
        $response->assertSee($reply->owner->name);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }
/** @test */
    public function a_thread_must_have_a_channel(): void
    {
        $channel = create(Channel::class );
        $thread = create(Thread::class , ['channel_id' => $channel->id]);
        $this->assertInstanceOf(Channel::class , $thread->channel);
    }
    /** @test */
    public function a_thread_has_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => $this->user->id,
        ]);
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public  function a_thread_can_make_a_string_path() : void{
        $thread = create(Thread::class,[ 'channel_id' => 1]);
        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id ,$thread->path());
        // fwrite(STDERR, print_r($thread->path(), true));
    }
    public function test_a_user_can_filter_threads_according_to_a_tag () :void{
        $channel = create(Channel::class);
        $threadNotInChannel = create(Thread::class);
        $threadInChannel = create(Thread::class , ['channel_id' => $channel->id]);
        $this->get('/threads/' . $channel->slug )
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel);
    }
}
