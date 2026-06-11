<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\User;
use App\Models\WorldCupTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        return User::factory()->create([
            'location_id'       => City::factory()->create()->id,
            'supported_team_id' => WorldCupTeam::factory()->create()->id,
        ]);
    }

    public function test_profile_page_is_displayed(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }

    public function test_password_can_be_updated(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->put('/password', [
                'current_password'      => 'password',
                'password'              => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_correct_password_must_be_provided_to_update(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->put('/password', [
                'current_password'      => 'wrong-password',
                'password'              => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertSessionHasErrors(
            ['current_password'],
            errorBag: 'updatePassword'
        );
    }
}
