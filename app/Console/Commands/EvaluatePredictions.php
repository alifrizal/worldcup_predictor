<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Services\PredictionScoringService;
use Illuminate\Console\Command;

class EvaluatePredictions extends Command
{
    protected $signature = 'predictions:evaluate {match_id : ID match yang akan dievaluasi}';

    protected $description = 'Evaluasi dan hitung poin semua prediksi untuk match yang sudah selesai';

    public function handle(PredictionScoringService $scorer): int
    {
        $fixture = Fixture::with(['homeTeam', 'awayTeam'])->find($this->argument('match_id'));

        if (! $fixture) {
            $this->error("Match ID {$this->argument('match_id')} tidak ditemukan.");
            return self::FAILURE;
        }

        $this->info("Match: {$fixture->homeTeam->name} {$fixture->home_score}–{$fixture->away_score} {$fixture->awayTeam->name}");

        try {
            $count = $scorer->evaluateMatch($fixture);
            $this->info("✅ {$count} prediksi berhasil dievaluasi.");
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
