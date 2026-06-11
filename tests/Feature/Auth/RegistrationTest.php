<?php

namespace Tests\Feature\Auth;

use App\Models\City;
use App\Models\WorldCupTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $city = City::factory()->create();
        $team = WorldCupTeam::factory()->create();

        $response = $this->post('/register', [
            'name'               => 'Test User',
            'email'              => 'test@example.com',
            'nickname'           => 'testuser',
            'x_account'          => 'testuser_x',
            'location_id'        => $city->id,
            'supported_team_id'  => $team->id,
            'password'           => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }
}
