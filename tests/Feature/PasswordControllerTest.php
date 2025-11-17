<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword')
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_wrong_current_password_fails()
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword')
        ]);

        $response = $this->actingAs($user)->from(route('password.update'))->put('/password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertSessionHasErrors('current_password');
    }
}
