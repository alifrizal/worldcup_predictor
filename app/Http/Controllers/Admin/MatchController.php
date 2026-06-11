<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Services\PredictionScoringService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(
        private PredictionScoringService $scorer
    ) {}

    public function index(): View
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_time')
            ->paginate(20);

        return view('admin.matches.index', compact('fixtures'));
    }

    public function edit(Fixture $fixture): View
    {
        $fixture->load(['homeTeam', 'awayTeam']);
        return view('admin.matches.edit', compact('fixture'));
    }

    public function update(Request $request, Fixture $fixture): RedirectResponse
    {
        $validated = $request->validate([
            'status'     => ['required', 'in:scheduled,live,finished'],
            'home_score' => ['nullable', 'integer', 'min:0', 'max:99'],
            'away_score' => ['nullable', 'integer', 'min:0', 'max:99'],
        ]);

        $wasFinished = $fixture->status === 'finished';
        $fixture->update($validated);

        // Auto evaluasi saat pertama kali status berubah ke finished
        if ($validated['status'] === 'finished' && ! $wasFinished) {
            try {
                $count = $this->scorer->evaluateMatch($fixture->fresh());
                return redirect()
                    ->route('admin.matches.index')
                    ->with('success', "Match diupdate & {$count} prediksi dievaluasi.");
            } catch (\RuntimeException $e) {
                return redirect()
                    ->route('admin.matches.index')
                    ->with('error', "Match diupdate tapi evaluasi gagal: {$e->getMessage()}");
            }
        }

        return redirect()
            ->route('admin.matches.index')
            ->with('success', 'Match berhasil diupdate.');
    }
}
