<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
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
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create(Reply::class);
        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }
        $this->assertCount(1, $reply->favorites);
    }
    public function test_an_authenticated_can_unfavorite_a_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $reply->favorite(auth()->id());
        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }
}
