<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $badges = [
            [
                'id'                          => 1,
                'badge_title'           => 'Bigginer',
            ],
            [
                'id'                          => 2,
                'badge_title'           => 'Intermediate',
            ],
            [
                'id'                          => 3,
                'badge_title'           => 'Advanced',
            ],
            [
                'id'                          => 4,
                'badge_title'           => 'Master',
            ],
        ];

        Badge::insert($badges);
    }
}
