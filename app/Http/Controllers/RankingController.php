<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\WorldCupTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RankingController extends Controller
{
    public function global(): View
    {
        $rankings = $this->buildRanking();

        $userRank = $rankings->search(fn($row) => $row->user_id === Auth::id());
        $userRank = $userRank !== false ? $userRank + 1 : null;

        return view('rankings.global', compact('rankings', 'userRank'));
    }

    public function location(Request $request): View
    {
        $user       = Auth::user();
        $cityId     = $request->query('city_id', $user->location_id);
        $city       = City::find($cityId);
        $cities     = City::orderByRaw("region = 'international'")
            ->orderBy('country')
            ->orderBy('name')
            ->get(['id', 'name', 'country', 'region']);

        $rankings = $this->buildRanking(locationId: $cityId);

        $userRank = $rankings->search(fn($row) => $row->user_id === Auth::id());
        $userRank = $userRank !== false ? $userRank + 1 : null;

        return view('rankings.location', compact('rankings', 'userRank', 'city', 'cities'));
    }

    public function team(Request $request): View
    {
        $user      = Auth::user();
        $teamId    = $request->query('team_id', $user->supported_team_id);
        $team      = WorldCupTeam::find($teamId);
        $teams     = WorldCupTeam::orderBy('group')->orderBy('name')->get();

        $rankings = $this->buildRanking(teamId: $teamId);

        $userRank = $rankings->search(fn($row) => $row->user_id === Auth::id());
        $userRank = $userRank !== false ? $userRank + 1 : null;

        return view('rankings.team', compact('rankings', 'userRank', 'team', 'teams'));
    }

    // ── Query Builder Ranking ─────────────────────────────────────────────────

    private function buildRanking(?int $locationId = null, ?int $teamId = null)
    {
        $query = DB::table('users')
            ->leftJoin('predictions', 'users.id', '=', 'predictions.user_id')
            ->leftJoin('cities', 'users.location_id', '=', 'cities.id')
            ->leftJoin('world_cup_teams', 'users.supported_team_id', '=', 'world_cup_teams.id')
            ->select([
                'users.id as user_id',
                'users.nickname',
                'cities.name as city_name',
                'world_cup_teams.name as team_name',
                'world_cup_teams.flag_emoji as team_flag',
                DB::raw('COALESCE(SUM(predictions.points), 0) as total_points'),
                DB::raw('COUNT(predictions.id) as total_predictions'),
                DB::raw('COUNT(CASE WHEN predictions.result_type = \'exact\' THEN 1 END) as exact_count'),
            ])
            ->groupBy([
                'users.id',
                'users.nickname',
                'cities.name',
                'world_cup_teams.name',
                'world_cup_teams.flag_emoji',
            ])
            ->orderByDesc('total_points')
            ->orderByDesc('exact_count') // tie-breaker: lebih banyak exact menang
            ->limit(100); // batasi top 100

        if ($locationId) {
            $query->where('users.location_id', $locationId);
        }

        if ($teamId) {
            $query->where('users.supported_team_id', $teamId);
        }

        return $query->get();
    }
}
