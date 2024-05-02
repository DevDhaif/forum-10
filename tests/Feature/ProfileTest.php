<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the admin role
        Role::create(['name' => 'admin']);
    }
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/profiles/{$user->name}");

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create(['name' => 'testuser']);

        $response = $this
            ->actingAs($user)
            ->patch("/profile/{$user->name}", [
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'user_id' => $user->id,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Test User',
                'email' => 'test@gmail.com'
            ])
            ->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@gmail.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_profile_information_can_be_updated_by_admin(): void
    {
        $user = User::factory()->create(['name' => 'testuser']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this
            ->actingAs($admin)
            ->patch("/profile/{$user->name}", [
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'user_id' => $user->id,
            ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Test User',
                'email' => 'test@gmail.com',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'id' => $user->id,
        ]);
    }
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch("/profile/{$user->name}", [
                'name' => 'Test User',
                'email' => $user->email,
                'user_id' => $user->id,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(200);

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete("/profile/{$user->name}", [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_admin_can_delete_user_account(): void
    {
        $user = User::factory()->create(['name' => 'testuser']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this
            ->actingAs($admin)
            ->delete("/profile/{$user->name}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);
        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
