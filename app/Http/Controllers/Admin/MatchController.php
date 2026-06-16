<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\WorldCupTeam;
use App\Services\PredictionScoringService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(
        private PredictionScoringService $scorer
    ) {}

    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = Fixture::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_time');

        if ($status) {
            $query->where('status', $status);
        }

        $fixtures = $query->paginate(20);

        return view('admin.matches.index', compact('fixtures'));
    }

    public function create(): View
    {
        $teams = WorldCupTeam::orderBy('group')->orderBy('name')->get();
        $stages = [
            'round_of_32'   => 'Round of 32',
            'round_of_16'   => 'Round of 16',
            'quarter_final' => 'Perempat Final',
            'semi_final'    => 'Semi Final',
            'third_place'   => 'Perebutan Juara 3',
            'final'         => 'Final',
        ];

        return view('admin.matches.create', compact('teams', 'stages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'home_team_id'  => ['required', 'exists:world_cup_teams,id', 'different:away_team_id'],
            'away_team_id'  => ['required', 'exists:world_cup_teams,id'],
            'stage'         => ['required', 'in:round_of_32,round_of_16,quarter_final,semi_final,third_place,final'],
            'match_time'    => ['required', 'date', 'after:now'],
            'venue'         => ['nullable', 'string', 'max:100'],
        ]);

        $validated['status']     = 'scheduled';
        $validated['group']      = null;

        Fixture::create($validated);

        return redirect()
            ->route('admin.matches.index')
            ->with('success', 'Fixture babak gugur berhasil ditambahkan.');
    }

    public function edit(Fixture $fixture): View
    {
        $fixture->load(['homeTeam', 'awayTeam']);

        // Untuk babak gugur, tim bisa diubah (placeholder → tim asli)
        $teams  = WorldCupTeam::orderBy('group')->orderBy('name')->get();
        $isKnockout = $fixture->stage !== 'group';

        return view('admin.matches.edit', compact('fixture', 'teams', 'isKnockout'));
    }

    public function update(Request $request, Fixture $fixture): RedirectResponse
    {
        $rules = [
            'status'     => ['required', 'in:scheduled,live,finished'],
            'home_score' => ['nullable', 'integer', 'min:0', 'max:99'],
            'away_score' => ['nullable', 'integer', 'min:0', 'max:99'],
        ];

        // Babak gugur bisa update tim juga
        if ($fixture->stage !== 'group') {
            $rules['home_team_id'] = ['required', 'exists:world_cup_teams,id', 'different:away_team_id'];
            $rules['away_team_id'] = ['required', 'exists:world_cup_teams,id'];
            $rules['match_time']   = ['required', 'date'];
            $rules['venue']        = ['nullable', 'string', 'max:100'];
        }

        $validated = $request->validate($rules);

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

    public function destroy(Fixture $fixture): RedirectResponse
    {
        if ($fixture->stage === 'group') {
            return back()->with('error', 'Fixture fase grup tidak bisa dihapus.');
        }

        $fixture->delete();

        return redirect()
            ->route('admin.matches.index')
            ->with('success', 'Fixture berhasil dihapus.');
    }
}
