<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Prediction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PredictionController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Ambil semua match yang scheduled/live, urutkan dari yang paling dekat
        $upcomingFixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('match_time')
            // ->limit(20)
            ->get();

        // Ambil semua match yang sudah selesai beserta prediksi user
        $finishedFixtures = Fixture::with([
            'homeTeam',
            'awayTeam',
            'predictions' => fn($q) => $q->where('user_id', $user->id)
        ])
            ->where('status', 'finished')
            ->orderByDesc('match_time')
            ->take(10)
            ->get();

        // Map prediksi user untuk match yang upcoming (untuk pre-fill form)
        $userPredictions = Prediction::where('user_id', $user->id)
            ->whereIn('match_id', $upcomingFixtures->pluck('id'))
            ->get()
            ->keyBy('match_id');

        return view('predictions.index', compact(
            'upcomingFixtures',
            'finishedFixtures',
            'userPredictions',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'match_id'   => ['required', 'exists:matches,id'],
            'home_score' => ['required', 'integer', 'min:0', 'max:99'],
            'away_score' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $fixture = Fixture::findOrFail($request->match_id);

        // Cek apakah match sudah dikunci (sudah mulai atau live/finished)
        if ($fixture->isLocked()) {
            return back()->with('error', 'Prediksi tidak bisa diubah, pertandingan sudah dimulai.');
        }

        Prediction::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'match_id' => $fixture->id,
            ],
            [
                'home_score' => $request->home_score,
                'away_score' => $request->away_score,
                // Reset evaluasi jika prediksi diubah sebelum match mulai
                'points'       => null,
                'result_type'  => null,
                'evaluated_at' => null,
            ]
        );

        return back()->with('success', 'Prediksi berhasil disimpan!');
    }
}
