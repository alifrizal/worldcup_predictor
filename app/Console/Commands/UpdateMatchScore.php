<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use Illuminate\Console\Command;

class UpdateMatchScore extends Command
{
    protected $signature = 'match:update-score
                            {id : ID match yang akan diupdate}
                            {--status= : Status match (live/finished)}
                            {--home= : Skor tim kandang}
                            {--away= : Skor tim tamu}';

    protected $description = 'Update skor dan status pertandingan';

    public function handle(): int
    {
        $fixture = Fixture::with(['homeTeam', 'awayTeam'])->find($this->argument('id'));

        if (! $fixture) {
            $this->error("Match dengan ID {$this->argument('id')} tidak ditemukan.");
            return self::FAILURE;
        }

        // Tampilkan info match
        $this->info("Match: {$fixture->homeTeam->flag_emoji} {$fixture->homeTeam->name} vs {$fixture->awayTeam->flag_emoji} {$fixture->awayTeam->name}");
        $this->info("Status saat ini : {$fixture->status}");
        $this->info("Skor saat ini   : {$fixture->home_score} - {$fixture->away_score}");
        $this->newLine();

        // Ambil nilai dari option atau tanya interaktif
        $status    = $this->option('status')
            ?? $this->choice('Status baru?', ['scheduled', 'live', 'finished'], $fixture->status);

        $homeScore = $this->option('home')
            ?? $this->ask('Skor tim kandang?', $fixture->home_score ?? 0);

        $awayScore = $this->option('away')
            ?? $this->ask('Skor tim tamu?', $fixture->away_score ?? 0);

        // Konfirmasi
        $this->table(
            ['Field', 'Nilai Lama', 'Nilai Baru'],
            [
                ['Status',        $fixture->status,      $status],
                ['Skor Kandang',  $fixture->home_score,  $homeScore],
                ['Skor Tamu',     $fixture->away_score,  $awayScore],
            ]
        );

        if (! $this->confirm('Simpan perubahan ini?', true)) {
            $this->warn('Dibatalkan.');
            return self::SUCCESS;
        }

        $fixture->update([
            'status'     => $status,
            'home_score' => $homeScore,
            'away_score' => $awayScore,
        ]);

        $this->info('✅ Match berhasil diupdate.');

        // Jika finished, trigger evaluasi prediksi (akan dipakai di Fase 4)
        if ($status === 'finished') {
            $this->info('🔄 Match selesai — jalankan evaluasi prediksi:');
            $this->line("   php artisan predictions:evaluate {$fixture->id}");
        }

        return self::SUCCESS;
    }
}
