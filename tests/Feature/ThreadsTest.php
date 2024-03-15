<?php

/**
 * Summary of namespace Tests\Feature
 */

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use LogicException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\TestCase;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use Inertia\Testing\AssertableCollection;

//  use testcase from phpunit

/**
 * Summary of ThreadsTest
 */
class ThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    use DatabaseMigrations;
    // a setup function to run before each test to create a user and sign them in and a thread
    /**
     * Summary of setUp
     * @return void
     */
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
    public function a_user_can_view_a_single_thread(): void
    {
        $response = $this->get("/threads/" . $this->thread->channel . '/' . $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_on_a_thread()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);
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
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);
        $this->assertInstanceOf(Channel::class, $thread->channel);
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
    public function a_thread_can_make_a_string_path(): void
    {
        $thread = create(Thread::class, ['channel_id' => 1]);
        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
        // fwrite(STDERR, print_r($thread->path(), true));
    }
    /**
     * @return void
     * @throws LogicException
     * @throws BadRequestException
     * @throws ExpectationFailedException
     */
    public function test_a_user_can_filter_threads_according_to_a_channel(): void
    {
        $channel = create(Channel::class);
        $threadNotInChannel = create(Thread::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel);
    }
    /**
     * Summary of test_a_user_can_filter_threads_by_any_username
     * @return void
     */
    public function test_a_user_can_filter_threads_by_any_username(): void
    {
        $this->signIn(create(User::class, ['name' => 'Dhaif']));

        $threadByDhaif = create(Thread::class, ['user_id' => auth()->id()]);
        $anotherThread = create(Thread::class);

        $this->get('/threads?by=Dhaif')->assertSee($threadByDhaif->title)->assertDontSee($anotherThread->title);
    }

    public function test_a_user_can_filter_threads_by_popularity(): void
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithZeroReplies = $this->thread;
        $response = $this->get('/threads?popular=1');
        $response->assertInertia(
            fn (AssertableInertia $page) =>
            $page->component('Thread/Index')
                ->where('threads.data', function ($threads) use ($threadWithThreeReplies, $threadWithTwoReplies, $threadWithZeroReplies) {
                    $threadsCollection = collect($threads);
                    return $threadsCollection->contains('id', $threadWithThreeReplies->id)
                        && $threadsCollection->contains('id', $threadWithTwoReplies->id)
                        && $threadsCollection->contains('id', $threadWithZeroReplies->id);
                })
        );
    }

    public function test_authorize_users_can_delete_threads(): void
    {
        $user = create(User::class);
        $this->actingAs($user);

        $thread = create(Thread::class, ['user_id' => $user->id]);
        $reply  =  create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $this->assertDatabaseMissing("threads", ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
        $response->assertStatus(302);
        $response->assertRedirect(route('threads'));
    }

    public function test_unauthorized_users_may_not_delete_threads(): void
    {
        $this->withExceptionHandling();
        $thread = create(Thread::class);
        // $this->delete($thread->path())->assertRedirect('/login');
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }
}
