<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Hitung breakdown hasil tebakan
        $breakdown = Prediction::where('user_id', $user->id)
            ->whereNotNull('result_type')
            ->select('result_type', DB::raw('count(*) as total'))
            ->groupBy('result_type')
            ->pluck('total', 'result_type')
            ->toArray();

        $exact  = $breakdown['exact']  ?? 0;
        $close  = $breakdown['close']  ?? 0;
        $result = $breakdown['result'] ?? 0;
        $wrong  = $breakdown['wrong']  ?? 0;

        $totalEvaluated = $exact + $close + $result + $wrong;

        // Total prediksi termasuk yang belum dievaluasi
        $totalPredictions = Prediction::where('user_id', $user->id)->count();

        // Total poin
        $totalPoints = Prediction::where('user_id', $user->id)
            ->sum('points');

        // Overall rank (global)
        $overallRank = DB::table('predictions')
            ->select('user_id', DB::raw('SUM(points) as total_points'))
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->get()
            ->search(fn($row) => $row->user_id === $user->id);

        $overallRank = $overallRank !== false ? $overallRank + 1 : null;

        // Total player aktif (pernah submit prediksi)
        $totalPlayers = DB::table('predictions')
            ->distinct('user_id')
            ->count('user_id');

        // Poin per stage
        $pointsPerStage = Prediction::where('predictions.user_id', $user->id)
            ->join('matches', 'predictions.match_id', '=', 'matches.id')
            ->select('matches.stage', DB::raw('SUM(predictions.points) as total_points'))
            ->groupBy('matches.stage')
            ->pluck('total_points', 'stage')
            ->toArray();

        $stageLabels = [
            'group'         => 'Fase Grup',
            'round_of_32'   => 'Round of 32',
            'round_of_16'   => 'Round of 16',
            'quarter_final' => 'Perempat Final',
            'semi_final'    => 'Semi Final',
            'third_place'   => 'Perebutan Juara 3',
            'final'         => 'Final',
        ];

        return view('statistics.index', compact(
            'exact',
            'close',
            'result',
            'wrong',
            'totalEvaluated',
            'totalPredictions',
            'totalPoints',
            'overallRank',
            'totalPlayers',
            'pointsPerStage',
            'stageLabels',
        ));
    }
}
