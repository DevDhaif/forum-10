<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class,
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        $this->assertEquals(2, Activity::count());
        // $this->assertDatabaseHas('activities', [
        //     'type' => 'created_reply',
        //     'user_id' => auth()->id(),
        //     'subject_id' => $reply->id,
        //     'subject_type' => Reply::class,
        // ]);
        // $activity = Activity::find(2);
        // $this->assertEquals($activity->subject->id, $reply->id);
    }
}
