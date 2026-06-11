<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(Request $request): View
    {
        $user        = Auth::user();
        $resultType  = $request->query('result_type');
        $stage       = $request->query('stage');
        $group       = $request->query('group');

        $query = Prediction::with(['fixture.homeTeam', 'fixture.awayTeam'])
            ->where('user_id', $user->id)
            ->whereHas('fixture', fn($q) => $q->where('status', 'finished'))
            ->orderByDesc(
                \App\Models\Fixture::select('match_time')
                    ->whereColumn('id', 'predictions.match_id')
            );

        if ($resultType) {
            $query->where('result_type', $resultType);
        }

        if ($stage) {
            $query->whereHas('fixture', fn($q) => $q->where('stage', $stage));
        }

        if ($stage === 'group' && $group) {
            $query->whereHas('fixture', fn($q) => $q->where('group', $group));
        }

        $predictions = $query->paginate(15)->withQueryString();

        $stages = [
            'group'         => 'Fase Grup',
            'round_of_32'   => 'Round of 32',
            'round_of_16'   => 'Round of 16',
            'quarter_final' => 'Perempat Final',
            'semi_final'    => 'Semi Final',
            'third_place'   => 'Perebutan Juara 3',
            'final'         => 'Final',
        ];

        $groups = collect(range('A', 'L'))->mapWithKeys(fn($g) => [$g => $g]);

        return view('history.index', compact(
            'predictions',
            'resultType',
            'stage',
            'group',
            'stages',
            'groups',
        ));
    }
}
