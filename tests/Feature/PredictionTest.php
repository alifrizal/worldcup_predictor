<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Fixture;
use App\Models\User;
use App\Models\WorldCupTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PredictionTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        $city = City::factory()->create();
        $team = WorldCupTeam::factory()->create();

        return User::factory()->create([
            'location_id'       => $city->id,
            'supported_team_id' => $team->id,
        ]);
    }

    private function createFixture(string $status = 'scheduled'): Fixture
    {
        $home = WorldCupTeam::factory()->create();
        $away = WorldCupTeam::factory()->create();

        return Fixture::factory()->create([
            'home_team_id' => $home->id,
            'away_team_id' => $away->id,
            'status'       => $status,
            'match_time'   => $status === 'scheduled'
                ? now()->addHours(2)
                : now()->subHours(2),
        ]);
    }

    public function test_user_can_submit_prediction(): void
    {
        $user    = $this->createUser();
        $fixture = $this->createFixture('scheduled');

        $response = $this->actingAs($user)->post(route('predictions.store'), [
            'match_id'   => $fixture->id,
            'home_score' => 2,
            'away_score' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('predictions', [
            'user_id'    => $user->id,
            'match_id'   => $fixture->id,
            'home_score' => 2,
            'away_score' => 1,
        ]);
    }

    public function test_user_cannot_predict_locked_match(): void
    {
        $user    = $this->createUser();
        $fixture = $this->createFixture('live');

        $response = $this->actingAs($user)->post(route('predictions.store'), [
            'match_id'   => $fixture->id,
            'home_score' => 1,
            'away_score' => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('predictions', [
            'user_id'  => $user->id,
            'match_id' => $fixture->id,
        ]);
    }

    public function test_user_can_update_prediction_before_lock(): void
    {
        $user    = $this->createUser();
        $fixture = $this->createFixture('scheduled');

        // Submit pertama
        $this->actingAs($user)->post(route('predictions.store'), [
            'match_id'   => $fixture->id,
            'home_score' => 1,
            'away_score' => 0,
        ]);

        // Update
        $this->actingAs($user)->post(route('predictions.store'), [
            'match_id'   => $fixture->id,
            'home_score' => 2,
            'away_score' => 1,
        ]);

        $this->assertDatabaseCount('predictions', 1);
        $this->assertDatabaseHas('predictions', [
            'user_id'    => $user->id,
            'match_id'   => $fixture->id,
            'home_score' => 2,
            'away_score' => 1,
        ]);
    }
}
