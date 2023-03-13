<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ReplyTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_it_has_an_owner()
    {
        $reply = create(Reply::class);
        // fwrite(STDERR, print_r($reply->toArray(), true));
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}


