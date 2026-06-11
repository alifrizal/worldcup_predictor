<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FixtureController extends Controller
{
    public function index(Request $request): View
    {
        $stage = $request->query('stage', 'group');
        $group = $request->query('group');

        $query = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('stage', $stage)
            ->orderBy('match_time');

        if ($stage === 'group' && $group) {
            $query->where('group', $group);
        }

        $fixtures = $query->get()->groupBy(function ($match) {
            return $match->match_time->format('Y-m-d');
        });

        $groups = collect(range('A', 'L'))->mapWithKeys(fn($g) => [$g => "Grup $g"]);

        $stages = [
            'group'         => 'Fase Grup',
            'round_of_32'   => 'Round of 32',
            'round_of_16'   => 'Round of 16',
            'quarter_final' => 'Perempat Final',
            'semi_final'    => 'Semi Final',
            'third_place'   => 'Perebutan Juara 3',
            'final'         => 'Final',
        ];

        return view('fixtures.index', compact('fixtures', 'stage', 'group', 'groups', 'stages'));
    }
}
