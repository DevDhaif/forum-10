<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling();
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }
    public function test_an_authenticated_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $this->post('reply/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_only_favorite_a_reply_once()
    {
        $user = User::factory()->create();
        $this->be($user);
        $reply = Reply::factory()->create();
        $this->post('reply/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
        $this->post('reply/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }
    public function test_an_authenticated_can_unfavorite_a_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $reply->toggleFavorite(auth()->id());
        $this->delete('reply/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }
}
