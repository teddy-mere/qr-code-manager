<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Nouveau Nom',
            'email' => 'nouveau@example.com'
        ]);

        $response->assertRedirect();
        $this->assertEquals('Nouveau Nom', $user->fresh()->name);
        $this->assertEquals('nouveau@example.com', $user->fresh()->email);
    }

    public function test_email_must_be_unique()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $response = $this->actingAs($user2)->from(route('profile.update'))->patch(route('profile.update'), [
            'name' => 'Test',
            'email' => 'user1@example.com'
        ]);

        $response->assertSessionHasErrors('email');
    }
}
