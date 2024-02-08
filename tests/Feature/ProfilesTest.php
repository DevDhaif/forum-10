<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_a_user_has_a_profile()
    {
        $university = \App\Models\University::factory()->create();
        $field = \App\Models\Field::factory()->create();
        $user = User::factory()->create([
            'university_id' => $university->id,
            'field_id' => $field->id,
        ]);
        $response = $this->get("/profiles/{$user->name}");
        $response->assertSee($user->name);

    }
    public function test_profiles_display_all_threads_created_by_the_associated_user()
    {
        $university = \App\Models\University::factory()->create();
        $field = \App\Models\Field::factory()->create();
        $user = User::factory()->create([
            'university_id' => $university->id,
            'field_id' => $field->id,
        ]);
        $this->be($user);

        $thread = Thread::factory()->create(['user_id' => $user->id]);
        $this->get("/profiles/" . $user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
