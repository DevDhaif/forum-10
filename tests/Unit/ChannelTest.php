<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ChannelTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_a_channel_consists_of_threads(): void
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }
}
