<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Prediction;

class PredictionScoringService
{
    /**
     * Evaluasi semua prediksi untuk satu match yang sudah selesai.
     */
    public function evaluateMatch(Fixture $fixture): int
    {
        if ($fixture->status !== 'finished') {
            throw new \RuntimeException("Match belum selesai, tidak bisa dievaluasi.");
        }

        if (is_null($fixture->home_score) || is_null($fixture->away_score)) {
            throw new \RuntimeException("Skor match belum diisi.");
        }

        $predictions = Prediction::where('match_id', $fixture->id)
            ->whereNull('evaluated_at')
            ->get();

        foreach ($predictions as $prediction) {
            [$points, $resultType] = $this->calculate(
                actualHome: $fixture->home_score,
                actualAway: $fixture->away_score,
                predictedHome: $prediction->home_score,
                predictedAway: $prediction->away_score,
            );

            $prediction->update([
                'points'       => $points,
                'result_type'  => $resultType,
                'evaluated_at' => now(),
            ]);
        }

        return $predictions->count();
    }

    /**
     * Hitung poin untuk satu prediksi.
     * Return: [float $points, string $resultType]
     */
    public function calculate(
        int $actualHome,
        int $actualAway,
        int $predictedHome,
        int $predictedAway,
    ): array {
        // EXACT: skor tepat sama persis
        if ($predictedHome === $actualHome && $predictedAway === $actualAway) {
            return [3.0, 'exact'];
        }

        $actualResult    = $this->getResult($actualHome, $actualAway);
        $predictedResult = $this->getResult($predictedHome, $predictedAway);

        // Hasil tidak benar → Wrong
        if ($actualResult !== $predictedResult) {
            return [0.0, 'wrong'];
        }

        // Hasil benar, cek close
        $actualMargin    = $actualHome - $actualAway;
        $predictedMargin = $predictedHome - $predictedAway;
        $marginDiff      = abs($predictedMargin - $actualMargin);

        // Untuk hasil draw: margin selalu 0 vs 0, jadi cek tambahan
        // selisih skor per tim maksimal 1
        if ($actualResult === 'draw') {
            $homeDiff = abs($predictedHome - $actualHome);
            $awayDiff = abs($predictedAway - $actualAway);

            if ($homeDiff <= 1 && $awayDiff <= 1) {
                return [1.5, 'close'];
            }

            return [1.0, 'result'];
        }

        // Untuk hasil non-draw: gunakan margin diff ≤ 1
        if ($marginDiff <= 1) {
            return [1.5, 'close'];
        }

        // Hasil benar tapi tidak close → Result
        return [1.0, 'result'];
    }

    /**
     * Tentukan hasil: 'home' | 'draw' | 'away'
     */
    private function getResult(int $home, int $away): string
    {
        if ($home > $away) return 'home';
        if ($home < $away) return 'away';
        return 'draw';
    }
}
