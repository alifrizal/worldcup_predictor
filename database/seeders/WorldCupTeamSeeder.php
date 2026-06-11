<?php

namespace Database\Seeders;

use App\Models\WorldCupTeam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorldCupTeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            // ── GRUP A ─────────────────────────────────────────────
            ['name' => 'Mexico',               'code' => 'MEX', 'flag_emoji' => '🇲🇽', 'group' => 'A'],
            ['name' => 'South Africa',         'code' => 'RSA', 'flag_emoji' => '🇿🇦', 'group' => 'A'],
            ['name' => 'South Korea',          'code' => 'KOR', 'flag_emoji' => '🇰🇷', 'group' => 'A'],
            ['name' => 'Czechia',              'code' => 'CZE', 'flag_emoji' => '🇨🇿', 'group' => 'A'],

            // ── GRUP B ─────────────────────────────────────────────
            ['name' => 'Canada',               'code' => 'CAN', 'flag_emoji' => '🇨🇦', 'group' => 'B'],
            ['name' => 'Bosnia-Herzegovina',   'code' => 'BIH', 'flag_emoji' => '🇧🇦', 'group' => 'B'],
            ['name' => 'Qatar',                'code' => 'QAT', 'flag_emoji' => '🇶🇦', 'group' => 'B'],
            ['name' => 'Switzerland',          'code' => 'SUI', 'flag_emoji' => '🇨🇭', 'group' => 'B'],

            // ── GRUP C ─────────────────────────────────────────────
            ['name' => 'Brazil',               'code' => 'BRA', 'flag_emoji' => '🇧🇷', 'group' => 'C'],
            ['name' => 'Morocco',              'code' => 'MAR', 'flag_emoji' => '🇲🇦', 'group' => 'C'],
            ['name' => 'Haiti',                'code' => 'HAI', 'flag_emoji' => '🇭🇹', 'group' => 'C'],
            ['name' => 'Scotland',             'code' => 'SCO', 'flag_emoji' => '🏴󠁧󠁢󠁳󠁣󠁴󠁿', 'group' => 'C'],

            // ── GRUP D ─────────────────────────────────────────────
            ['name' => 'United States',        'code' => 'USA', 'flag_emoji' => '🇺🇸', 'group' => 'D'],
            ['name' => 'Paraguay',             'code' => 'PAR', 'flag_emoji' => '🇵🇾', 'group' => 'D'],
            ['name' => 'Australia',            'code' => 'AUS', 'flag_emoji' => '🇦🇺', 'group' => 'D'],
            ['name' => 'Türkiye',              'code' => 'TUR', 'flag_emoji' => '🇹🇷', 'group' => 'D'],

            // ── GRUP E ─────────────────────────────────────────────
            ['name' => 'Germany',              'code' => 'GER', 'flag_emoji' => '🇩🇪', 'group' => 'E'],
            ['name' => 'Curaçao',              'code' => 'CUW', 'flag_emoji' => '🇨🇼', 'group' => 'E'],
            ['name' => 'Ivory Coast',          'code' => 'CIV', 'flag_emoji' => '🇨🇮', 'group' => 'E'],
            ['name' => 'Ecuador',              'code' => 'ECU', 'flag_emoji' => '🇪🇨', 'group' => 'E'],

            // ── GRUP F ─────────────────────────────────────────────
            ['name' => 'Netherlands',          'code' => 'NED', 'flag_emoji' => '🇳🇱', 'group' => 'F'],
            ['name' => 'Japan',                'code' => 'JPN', 'flag_emoji' => '🇯🇵', 'group' => 'F'],
            ['name' => 'Sweden',               'code' => 'SWE', 'flag_emoji' => '🇸🇪', 'group' => 'F'],
            ['name' => 'Tunisia',              'code' => 'TUN', 'flag_emoji' => '🇹🇳', 'group' => 'F'],

            // ── GRUP G ─────────────────────────────────────────────
            ['name' => 'Belgium',              'code' => 'BEL', 'flag_emoji' => '🇧🇪', 'group' => 'G'],
            ['name' => 'Egypt',                'code' => 'EGY', 'flag_emoji' => '🇪🇬', 'group' => 'G'],
            ['name' => 'Iran',                 'code' => 'IRN', 'flag_emoji' => '🇮🇷', 'group' => 'G'],
            ['name' => 'New Zealand',          'code' => 'NZL', 'flag_emoji' => '🇳🇿', 'group' => 'G'],

            // ── GRUP H ─────────────────────────────────────────────
            ['name' => 'Spain',                'code' => 'ESP', 'flag_emoji' => '🇪🇸', 'group' => 'H'],
            ['name' => 'Cape Verde',           'code' => 'CPV', 'flag_emoji' => '🇨🇻', 'group' => 'H'],
            ['name' => 'Saudi Arabia',         'code' => 'KSA', 'flag_emoji' => '🇸🇦', 'group' => 'H'],
            ['name' => 'Uruguay',              'code' => 'URU', 'flag_emoji' => '🇺🇾', 'group' => 'H'],

            // ── GRUP I ─────────────────────────────────────────────
            ['name' => 'France',               'code' => 'FRA', 'flag_emoji' => '🇫🇷', 'group' => 'I'],
            ['name' => 'Senegal',              'code' => 'SEN', 'flag_emoji' => '🇸🇳', 'group' => 'I'],
            ['name' => 'Iraq',                 'code' => 'IRQ', 'flag_emoji' => '🇮🇶', 'group' => 'I'],
            ['name' => 'Norway',               'code' => 'NOR', 'flag_emoji' => '🇳🇴', 'group' => 'I'],

            // ── GRUP J ─────────────────────────────────────────────
            ['name' => 'Argentina',            'code' => 'ARG', 'flag_emoji' => '🇦🇷', 'group' => 'J'],
            ['name' => 'Algeria',              'code' => 'ALG', 'flag_emoji' => '🇩🇿', 'group' => 'J'],
            ['name' => 'Austria',              'code' => 'AUT', 'flag_emoji' => '🇦🇹', 'group' => 'J'],
            ['name' => 'Jordan',               'code' => 'JOR', 'flag_emoji' => '🇯🇴', 'group' => 'J'],

            // ── GRUP K ─────────────────────────────────────────────
            ['name' => 'Portugal',             'code' => 'POR', 'flag_emoji' => '🇵🇹', 'group' => 'K'],
            ['name' => 'DR Congo',             'code' => 'COD', 'flag_emoji' => '🇨🇩', 'group' => 'K'],
            ['name' => 'Uzbekistan',           'code' => 'UZB', 'flag_emoji' => '🇺🇿', 'group' => 'K'],
            ['name' => 'Colombia',             'code' => 'COL', 'flag_emoji' => '🇨🇴', 'group' => 'K'],

            // ── GRUP L ─────────────────────────────────────────────
            ['name' => 'England',              'code' => 'ENG', 'flag_emoji' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿', 'group' => 'L'],
            ['name' => 'Croatia',              'code' => 'CRO', 'flag_emoji' => '🇭🇷', 'group' => 'L'],
            ['name' => 'Ghana',                'code' => 'GHA', 'flag_emoji' => '🇬🇭', 'group' => 'L'],
            ['name' => 'Panama',               'code' => 'PAN', 'flag_emoji' => '🇵🇦', 'group' => 'L'],
        ];

        foreach ($teams as $team) {
            WorldCupTeam::updateOrCreate(
                ['code' => $team['code']],
                [
                    'name'       => $team['name'],
                    'flag_emoji' => $team['flag_emoji'],
                    'group'      => $team['group'],
                    'slug'       => Str::slug($team['name']),
                ]
            );
        }

        $this->command->info('✅ 48 tim Piala Dunia 2026 berhasil di-seed.');
    }
}
