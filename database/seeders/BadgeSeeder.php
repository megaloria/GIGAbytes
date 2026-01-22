<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Confident Speaker',
                'description' => 'Complete 5 speaking tasks',
                'icon' => 'bi-mic-fill',
                'criteria_type' => 'speaking_count',
                'criteria_value' => 5,
            ],
            [
                'name' => 'Creative Writer',
                'description' => 'Complete 5 writing tasks',
                'icon' => 'bi-pencil-fill',
                'criteria_type' => 'writing_count',
                'criteria_value' => 5,
            ],
            [
                'name' => 'Weekly Challenger',
                'description' => 'Submit tasks for 4 consecutive weeks',
                'icon' => 'bi-calendar-check-fill',
                'criteria_type' => 'streak',
                'criteria_value' => 4,
            ],
            [
                'name' => 'Consistent Learner',
                'description' => 'Reach Level 5',
                'icon' => 'bi-star-fill',
                'criteria_type' => 'level',
                'criteria_value' => 5,
            ],
            [
                'name' => 'Rising Star',
                'description' => 'Reach Level 10',
                'icon' => 'bi-trophy-fill',
                'criteria_type' => 'level',
                'criteria_value' => 10,
            ],
            [
                'name' => 'Grammar Expert',
                'description' => 'Score 90+ on 10 writing tasks',
                'icon' => 'bi-book-fill',
                'criteria_type' => 'high_writing_score',
                'criteria_value' => 10,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
