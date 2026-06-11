<?php

namespace Database\Seeders;

use App\Models\Fixture;
use App\Models\WorldCupTeam;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FixtureSeeder extends Seeder
{
    public function run(): void
    {
        $team = fn(string $code) => WorldCupTeam::where('code', $code)->value('id');

        // Helper: konversi jam lokal ke UTC untuk disimpan di DB
        $wib = fn(string $datetime) => Carbon::createFromFormat(
            'Y-m-d H:i',
            $datetime,
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');

        $matches = [
            // ── GRUP A ─────────────────────────────── MEX · RSA · KOR · CZE
            ['home' => 'MEX', 'away' => 'RSA',  'time' => $wib('2026-06-12 02:00'), 'group' => 'A', 'venue' => 'Mexico City'],
            ['home' => 'KOR', 'away' => 'CZE',  'time' => $wib('2026-06-12 09:00'), 'group' => 'A', 'venue' => 'Guadalajara'],
            ['home' => 'CZE', 'away' => 'RSA',  'time' => $wib('2026-06-18 23:00'), 'group' => 'A', 'venue' => 'Atlanta'],
            ['home' => 'MEX', 'away' => 'KOR',  'time' => $wib('2026-06-19 08:00'), 'group' => 'A', 'venue' => 'Guadalajara'],
            ['home' => 'CZE', 'away' => 'MEX',  'time' => $wib('2026-06-25 08:00'), 'group' => 'A', 'venue' => 'Mexico City'],
            ['home' => 'RSA', 'away' => 'KOR',  'time' => $wib('2026-06-25 08:00'), 'group' => 'A', 'venue' => 'Monterrey'],

            // ── GRUP B ─────────────────────────────── CAN · BIH · QAT · SUI
            ['home' => 'CAN', 'away' => 'BIH',  'time' => $wib('2026-06-13 02:00'), 'group' => 'B', 'venue' => 'Toronto'],
            ['home' => 'QAT', 'away' => 'SUI',  'time' => $wib('2026-06-14 02:00'), 'group' => 'B', 'venue' => 'San Francisco'],
            ['home' => 'SUI', 'away' => 'BIH',  'time' => $wib('2026-06-19 02:00'), 'group' => 'B', 'venue' => 'Los Angeles'],
            ['home' => 'CAN', 'away' => 'QAT',  'time' => $wib('2026-06-19 05:00'), 'group' => 'B', 'venue' => 'Vancouver'],
            ['home' => 'SUI', 'away' => 'CAN',  'time' => $wib('2026-06-25 02:00'), 'group' => 'B', 'venue' => 'Vancouver'],
            ['home' => 'BIH', 'away' => 'QAT',  'time' => $wib('2026-06-25 02:00'), 'group' => 'B', 'venue' => 'Seattle'],

            // ── GRUP C ─────────────────────────────── BRA · MAR · HAI · SCO
            ['home' => 'BRA', 'away' => 'MAR',  'time' => $wib('2026-06-14 05:00'), 'group' => 'C', 'venue' => 'New Jersey'],
            ['home' => 'HAI', 'away' => 'SCO',  'time' => $wib('2026-06-14 08:00'), 'group' => 'C', 'venue' => 'Boston'],
            ['home' => 'SCO', 'away' => 'MAR',  'time' => $wib('2026-06-20 05:00'), 'group' => 'C', 'venue' => 'Boston'],
            ['home' => 'BRA', 'away' => 'HAI',  'time' => $wib('2026-06-20 07:30'), 'group' => 'C', 'venue' => 'Philadelphia'],
            ['home' => 'SCO', 'away' => 'BRA',  'time' => $wib('2026-06-25 05:00'), 'group' => 'C', 'venue' => 'Miami'],
            ['home' => 'MAR', 'away' => 'HAI',  'time' => $wib('2026-06-25 05:00'), 'group' => 'C', 'venue' => 'Atlanta'],

            // ── GRUP D ─────────────────────────────── USA · PAR · AUS · TUR
            ['home' => 'USA', 'away' => 'PAR',  'time' => $wib('2026-06-13 08:00'), 'group' => 'D', 'venue' => 'Los Angeles'],
            ['home' => 'AUS', 'away' => 'TUR',  'time' => $wib('2026-06-14 11:00'), 'group' => 'D', 'venue' => 'Vancouver'],
            ['home' => 'USA', 'away' => 'AUS',  'time' => $wib('2026-06-20 02:00'), 'group' => 'D', 'venue' => 'Seattle'],
            ['home' => 'TUR', 'away' => 'PAR',  'time' => $wib('2026-06-20 10:00'), 'group' => 'D', 'venue' => 'San Francisco'],
            ['home' => 'TUR', 'away' => 'USA',  'time' => $wib('2026-06-26 09:00'), 'group' => 'D', 'venue' => 'Los Angeles'],
            ['home' => 'PAR', 'away' => 'AUS',  'time' => $wib('2026-06-26 09:00'), 'group' => 'D', 'venue' => 'San Francisco'],

            // ── GRUP E ─────────────────────────────── GER · CUW · CIV · ECU
            ['home' => 'GER', 'away' => 'CUW',  'time' => $wib('2026-06-15 00:00'), 'group' => 'E', 'venue' => 'Houston'],
            ['home' => 'CIV', 'away' => 'ECU',  'time' => $wib('2026-06-15 06:00'), 'group' => 'E', 'venue' => 'Philadelphia'],
            ['home' => 'GER', 'away' => 'CIV',  'time' => $wib('2026-06-21 03:00'), 'group' => 'E', 'venue' => 'Toronto'],
            ['home' => 'ECU', 'away' => 'CUW',  'time' => $wib('2026-06-21 07:00'), 'group' => 'E', 'venue' => 'Kansas City'],
            ['home' => 'CUW', 'away' => 'CIV',  'time' => $wib('2026-06-26 03:00'), 'group' => 'E', 'venue' => 'Philadelphia'],
            ['home' => 'ECU', 'away' => 'GER',  'time' => $wib('2026-06-26 03:00'), 'group' => 'E', 'venue' => 'New Jersey'],

            // ── GRUP F ─────────────────────────────── NED · JPN · SWE · TUN
            ['home' => 'NED', 'away' => 'JPN',  'time' => $wib('2026-06-15 03:00'), 'group' => 'F', 'venue' => 'Dallas'],
            ['home' => 'SWE', 'away' => 'TUN',  'time' => $wib('2026-06-15 09:00'), 'group' => 'F', 'venue' => 'Monterrey'],
            ['home' => 'NED', 'away' => 'SWE',  'time' => $wib('2026-06-21 00:00'), 'group' => 'F', 'venue' => 'Houston'],
            ['home' => 'TUN', 'away' => 'JPN',  'time' => $wib('2026-06-21 11:00'), 'group' => 'F', 'venue' => 'Monterrey'],
            ['home' => 'JPN', 'away' => 'SWE',  'time' => $wib('2026-06-26 06:00'), 'group' => 'F', 'venue' => 'Dallas'],
            ['home' => 'TUN', 'away' => 'NED',  'time' => $wib('2026-06-26 06:00'), 'group' => 'F', 'venue' => 'Kansas City'],

            // ── GRUP G ─────────────────────────────── BEL · EGY · IRN · NZL
            ['home' => 'BEL', 'away' => 'EGY',  'time' => $wib('2026-06-16 02:00'), 'group' => 'G', 'venue' => 'Seattle'],
            ['home' => 'IRN', 'away' => 'NZL',  'time' => $wib('2026-06-16 08:00'), 'group' => 'G', 'venue' => 'Los Angeles'],
            ['home' => 'BEL', 'away' => 'IRN',  'time' => $wib('2026-06-22 02:00'), 'group' => 'G', 'venue' => 'Los Angeles'],
            ['home' => 'NZL', 'away' => 'EGY',  'time' => $wib('2026-06-22 08:00'), 'group' => 'G', 'venue' => 'Vancouver'],
            ['home' => 'EGY', 'away' => 'IRN',  'time' => $wib('2026-06-27 10:00'), 'group' => 'G', 'venue' => 'Seattle'],
            ['home' => 'NZL', 'away' => 'BEL',  'time' => $wib('2026-06-27 10:00'), 'group' => 'G', 'venue' => 'Vancouver'],

            // ── GRUP H ─────────────────────────────── ESP · CPV · KSA · URU
            ['home' => 'ESP', 'away' => 'CPV',  'time' => $wib('2026-06-15 23:00'), 'group' => 'H', 'venue' => 'Atlanta'],
            ['home' => 'KSA', 'away' => 'URU',  'time' => $wib('2026-06-16 05:00'), 'group' => 'H', 'venue' => 'Miami'],
            ['home' => 'ESP', 'away' => 'KSA',  'time' => $wib('2026-06-21 23:00'), 'group' => 'H', 'venue' => 'Atlanta'],
            ['home' => 'URU', 'away' => 'CPV',  'time' => $wib('2026-06-22 05:00'), 'group' => 'H', 'venue' => 'Miami'],
            ['home' => 'CPV', 'away' => 'KSA',  'time' => $wib('2026-06-27 07:00'), 'group' => 'H', 'venue' => 'Houston'],
            ['home' => 'URU', 'away' => 'ESP',  'time' => $wib('2026-06-27 07:00'), 'group' => 'H', 'venue' => 'Guadalajara'],

            // ── GRUP I ─────────────────────────────── FRA · SEN · IRQ · NOR
            ['home' => 'FRA', 'away' => 'SEN',  'time' => $wib('2026-06-17 02:00'), 'group' => 'I', 'venue' => 'New Jersey'],
            ['home' => 'IRQ', 'away' => 'NOR',  'time' => $wib('2026-06-17 05:00'), 'group' => 'I', 'venue' => 'Boston'],
            ['home' => 'FRA', 'away' => 'IRQ',  'time' => $wib('2026-06-23 04:00'), 'group' => 'I', 'venue' => 'Philadelphia'],
            ['home' => 'NOR', 'away' => 'SEN',  'time' => $wib('2026-06-23 07:00'), 'group' => 'I', 'venue' => 'New Jersey'],
            ['home' => 'NOR', 'away' => 'FRA',  'time' => $wib('2026-06-27 02:00'), 'group' => 'I', 'venue' => 'Boston'],
            ['home' => 'SEN', 'away' => 'IRQ',  'time' => $wib('2026-06-27 02:00'), 'group' => 'I', 'venue' => 'Toronto'],

            // ── GRUP J ─────────────────────────────── ARG · ALG · AUT · JOR
            ['home' => 'ARG', 'away' => 'ALG',  'time' => $wib('2026-06-17 08:00'), 'group' => 'J', 'venue' => 'Kansas City'],
            ['home' => 'AUT', 'away' => 'JOR',  'time' => $wib('2026-06-17 11:00'), 'group' => 'J', 'venue' => 'San Francisco'],
            ['home' => 'ARG', 'away' => 'AUT',  'time' => $wib('2026-06-23 00:00'), 'group' => 'J', 'venue' => 'Dallas'],
            ['home' => 'JOR', 'away' => 'ALG',  'time' => $wib('2026-06-23 10:00'), 'group' => 'J', 'venue' => 'San Francisco'],
            ['home' => 'ALG', 'away' => 'AUT',  'time' => $wib('2026-06-28 09:00'), 'group' => 'J', 'venue' => 'Kansas City'],
            ['home' => 'JOR', 'away' => 'ARG',  'time' => $wib('2026-06-28 09:00'), 'group' => 'J', 'venue' => 'Dallas'],

            // ── GRUP K ─────────────────────────────── POR · COD · UZB · COL
            ['home' => 'POR', 'away' => 'COD',  'time' => $wib('2026-06-18 00:00'), 'group' => 'K', 'venue' => 'Houston'],
            ['home' => 'UZB', 'away' => 'COL',  'time' => $wib('2026-06-18 09:00'), 'group' => 'K', 'venue' => 'Mexico City'],
            ['home' => 'POR', 'away' => 'UZB',  'time' => $wib('2026-06-24 00:00'), 'group' => 'K', 'venue' => 'Houston'],
            ['home' => 'COL', 'away' => 'COD',  'time' => $wib('2026-06-24 09:00'), 'group' => 'K', 'venue' => 'Guadalajara'],
            ['home' => 'COL', 'away' => 'POR',  'time' => $wib('2026-06-28 06:30'), 'group' => 'K', 'venue' => 'Miami'],
            ['home' => 'COD', 'away' => 'UZB',  'time' => $wib('2026-06-28 06:30'), 'group' => 'K', 'venue' => 'Atlanta'],

            // ── GRUP L ─────────────────────────────── ENG · CRO · GHA · PAN
            ['home' => 'ENG', 'away' => 'CRO',  'time' => $wib('2026-06-18 03:00'), 'group' => 'L', 'venue' => 'Dallas'],
            ['home' => 'GHA', 'away' => 'PAN',  'time' => $wib('2026-06-18 06:00'), 'group' => 'L', 'venue' => 'Toronto'],
            ['home' => 'ENG', 'away' => 'GHA',  'time' => $wib('2026-06-24 03:00'), 'group' => 'L', 'venue' => 'Boston'],
            ['home' => 'PAN', 'away' => 'CRO',  'time' => $wib('2026-06-24 06:00'), 'group' => 'L', 'venue' => 'Toronto'],
            ['home' => 'PAN', 'away' => 'ENG',  'time' => $wib('2026-06-28 04:00'), 'group' => 'L', 'venue' => 'New Jersey'],
            ['home' => 'CRO', 'away' => 'GHA',  'time' => $wib('2026-06-28 04:00'), 'group' => 'L', 'venue' => 'Philadeplphia'],
        ];

        foreach ($matches as $data) {
            Fixture::updateOrCreate(
                [
                    'home_team_id' => $team($data['home']),
                    'away_team_id' => $team($data['away']),
                    'stage'        => 'group',
                ],
                [
                    'match_time' => $data['time'],
                    'group'      => $data['group'],
                    'venue'      => $data['venue'],
                    'status'     => 'scheduled',
                ]
            );
        }

        $this->command->info('✅ ' . count($matches) . ' fixture fase grup berhasil di-seed.');
    }
}
