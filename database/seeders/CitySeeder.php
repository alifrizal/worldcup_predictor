<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            // ── INDONESIA ──────────────────────────────────────────
            ['name' => 'Jakarta',       'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Surabaya',      'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Bandung',       'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Medan',         'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Semarang',      'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Makassar',      'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Palembang',     'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Tangerang',     'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Depok',         'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Bekasi',        'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Bogor',         'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Yogyakarta',    'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Malang',        'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Denpasar',      'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Batam',         'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Pekanbaru',     'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Bandar Lampung', 'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Padang',        'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Samarinda',     'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Balikpapan',    'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Pontianak',     'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Banjarmasin',   'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Manado',        'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Jambi',         'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Mataram',       'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Kupang',        'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Ambon',         'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Jayapura',      'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Sorong',        'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Nusantara',     'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Bengkulu',      'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Palu',          'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Kendari',       'country' => 'Indonesia', 'region' => 'indonesia'],
            ['name' => 'Banda Aceh',    'country' => 'Indonesia', 'region' => 'indonesia'],

            // ── INTERNASIONAL ───────────────────────────────────────
            // Amerika
            ['name' => 'New York',      'country' => 'United States',  'region' => 'international'],
            ['name' => 'Los Angeles',   'country' => 'United States',  'region' => 'international'],
            ['name' => 'Chicago',       'country' => 'United States',  'region' => 'international'],
            ['name' => 'Houston',       'country' => 'United States',  'region' => 'international'],
            ['name' => 'Toronto',       'country' => 'Canada',         'region' => 'international'],
            ['name' => 'Mexico City',   'country' => 'Mexico',         'region' => 'international'],
            ['name' => 'São Paulo',     'country' => 'Brazil',         'region' => 'international'],
            ['name' => 'Buenos Aires',  'country' => 'Argentina',      'region' => 'international'],
            ['name' => 'Bogotá',        'country' => 'Colombia',       'region' => 'international'],
            ['name' => 'Lima',          'country' => 'Peru',           'region' => 'international'],
            ['name' => 'Santiago',      'country' => 'Chile',          'region' => 'international'],

            // Eropa
            ['name' => 'London',        'country' => 'England',        'region' => 'international'],
            ['name' => 'Paris',         'country' => 'France',         'region' => 'international'],
            ['name' => 'Berlin',        'country' => 'Germany',        'region' => 'international'],
            ['name' => 'Madrid',        'country' => 'Spain',          'region' => 'international'],
            ['name' => 'Rome',          'country' => 'Italy',          'region' => 'international'],
            ['name' => 'Amsterdam',     'country' => 'Netherlands',    'region' => 'international'],
            ['name' => 'Brussels',      'country' => 'Belgium',        'region' => 'international'],
            ['name' => 'Lisbon',        'country' => 'Portugal',       'region' => 'international'],
            ['name' => 'Moscow',        'country' => 'Russia',         'region' => 'international'],
            ['name' => 'Istanbul',      'country' => 'Turkey',         'region' => 'international'],
            ['name' => 'Zurich',        'country' => 'Switzerland',    'region' => 'international'],
            ['name' => 'Vienna',        'country' => 'Austria',        'region' => 'international'],
            ['name' => 'Warsaw',        'country' => 'Poland',         'region' => 'international'],

            // Asia
            ['name' => 'Tokyo',         'country' => 'Japan',          'region' => 'international'],
            ['name' => 'Seoul',         'country' => 'South Korea',    'region' => 'international'],
            ['name' => 'Beijing',       'country' => 'China',          'region' => 'international'],
            ['name' => 'Shanghai',      'country' => 'China',          'region' => 'international'],
            ['name' => 'Singapore',     'country' => 'Singapore',      'region' => 'international'],
            ['name' => 'Kuala Lumpur',  'country' => 'Malaysia',       'region' => 'international'],
            ['name' => 'Bangkok',       'country' => 'Thailand',       'region' => 'international'],
            ['name' => 'Ho Chi Minh',   'country' => 'Vietnam',        'region' => 'international'],
            ['name' => 'Manila',        'country' => 'Philippines',    'region' => 'international'],
            ['name' => 'Mumbai',        'country' => 'India',          'region' => 'international'],
            ['name' => 'New Delhi',     'country' => 'India',          'region' => 'international'],
            ['name' => 'Riyadh',        'country' => 'Saudi Arabia',   'region' => 'international'],
            ['name' => 'Dubai',         'country' => 'UAE',            'region' => 'international'],
            ['name' => 'Doha',          'country' => 'Qatar',          'region' => 'international'],
            ['name' => 'Tehran',        'country' => 'Iran',           'region' => 'international'],

            // Afrika & Oseania
            ['name' => 'Cairo',         'country' => 'Egypt',          'region' => 'international'],
            ['name' => 'Lagos',         'country' => 'Nigeria',        'region' => 'international'],
            ['name' => 'Johannesburg',  'country' => 'South Africa',   'region' => 'international'],
            ['name' => 'Casablanca',    'country' => 'Morocco',        'region' => 'international'],
            ['name' => 'Nairobi',       'country' => 'Kenya',          'region' => 'international'],
            ['name' => 'Sydney',        'country' => 'Australia',      'region' => 'international'],
            ['name' => 'Melbourne',     'country' => 'Australia',      'region' => 'international'],
            ['name' => 'Auckland',      'country' => 'New Zealand',    'region' => 'international'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['slug' => Str::slug($city['name'])],
                [
                    'name'    => $city['name'],
                    'country' => $city['country'],
                    'region'  => $city['region'],
                    'slug'    => Str::slug($city['name']),
                ]
            );
        }
    }
}
