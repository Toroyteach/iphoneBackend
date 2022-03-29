<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $achievements = [
            [
                'id'                          => 1,
                'achievement_title'           => 'first lesson watched',
            ],
            [
                'id'                          => 2,
                'achievement_title'           => '5 lessons watched',
            ],
            [
                'id'                          => 3,
                'achievement_title'           => '10 lessons watched',
            ],
            [
                'id'                          => 4,
                'achievement_title'           => '25 lessons watched',
            ],
            [
                'id'                          => 5,
                'achievement_title'           => '50 lessons watched',
            ],
            [
                'id'                          => 6,
                'achievement_title'           => 'first comment written',
            ],
            [
                'id'                          => 7,
                'achievement_title'           => '3 comments written',
            ],
            [
                'id'                          => 8,
                'achievement_title'           => '5 comments written',
            ],
            [
                'id'                          => 9,
                'achievement_title'           => '10 comments written',
            ],
            [
                'id'                          => 10,
                'achievement_title'           => '20 comments written',
            ],
        ];

        Achievement::insert($achievements);
    }
}
