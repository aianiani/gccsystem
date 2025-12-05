<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seminar;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seminars = [
            [
                'name' => 'IDREAMS',
                'description' => 'Seminar for 1st Year Students focusing on self-awareness and adjustment to college life.',
                'target_year_level' => 1,
            ],
            [
                'name' => '10C',
                'description' => 'Seminar for 2nd Year Students focusing on character building and values formation.',
                'target_year_level' => 2,
            ],
            [
                'name' => 'LEADS',
                'description' => 'Seminar for 3rd Year Students focusing on leadership and social responsibility.',
                'target_year_level' => 3,
            ],
            [
                'name' => 'IMAGE',
                'description' => 'Seminar for 4th Year Students focusing on career preparation and professional image.',
                'target_year_level' => 4,
            ],
        ];

        foreach ($seminars as $seminar) {
            Seminar::firstOrCreate(
                ['name' => $seminar['name']],
                $seminar
            );
        }
    }
}
