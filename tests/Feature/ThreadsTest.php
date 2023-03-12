<?php

namespace Tests\Feature;

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
        $this->user = User::factory()->create();
        $this->thread = Thread::factory()->create();
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
    public function a_user_can_view_a_single_thread()
    {
        $response = $this->get("/threads/" . $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_on_a_thread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);
        $response = $this->get("/threads/" . $this->thread->id);
        $response->assertSee($reply->owner->name);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
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
}
