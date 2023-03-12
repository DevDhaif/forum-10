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

    /**
     * A basic unit test example.
     */
    // public function setUp(): void
    // {
    //     parent::setUp();
    //     $this->user = User::factory()->create();
    //     $this->thread = Thread::factory()->create();
    // }
    // function to test that a reply has an owner
    public function test_it_has_an_owner()
    {
        $reply = Reply::factory()->create();
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
