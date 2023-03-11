<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
class ThreadTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

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
        // $user = User::factory()->create();
        $response = $this->get('/threads');
        $response->assertStatus(200);
        $response->assertSee($this->thread->body);
    }
}
